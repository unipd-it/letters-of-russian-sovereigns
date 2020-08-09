<?php

declare(strict_types=1);

/*
 * This file is part of «Letters of Russian sovereigns to the Republic of Venice» database.
 *
 * Copyright (c) Department of Linguistic and Literary Studies of the University of Padova
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is free software:
 * you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, version 3.
 *
 * «Letters of Russian sovereigns to the Republic of Venice» database is distributed
 * in the hope  that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. If you have not received
 * a copy of the GNU General Public License along with
 * «Letters of Russian sovereigns to the Republic of Venice» database,
 * see <http://www.gnu.org/licenses/>.
 */

namespace App\Import\RawData\Bibliography;

use App\Persistence\Repository\Letter\LetterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Vyfony\Bundle\BibliographyBundle\Persistence\Entity\Author;
use Vyfony\Bundle\BibliographyBundle\Persistence\Entity\Authorship;
use Vyfony\Bundle\BibliographyBundle\Persistence\Entity\BibliographicRecord;
use Vyfony\Bundle\BibliographyBundle\Persistence\Repository\BibliographicRecordRepository;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class RawBibliographyImporter implements RawBibliographyImporterInterface
{
    /**
     * @var LetterRepository
     */
    private $letterRepository;

    /**
     * @var BibliographicRecordRepository
     */
    private $bibliographicRecordRepository;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    public function __construct(
        LetterRepository $letterRepository,
        BibliographicRecordRepository $bibliographicRecordRepository,
        EntityManagerInterface $doctrine
    ) {
        $this->letterRepository = $letterRepository;
        $this->bibliographicRecordRepository = $bibliographicRecordRepository;
        $this->doctrine = $doctrine;
    }

    public function importBibliography(string $sourceDirectory): void
    {
        $this->importAuthors($sourceDirectory);

        $this->importRecords($sourceDirectory);

        $this->bindRecordsToAuthors($sourceDirectory);
    }

    private function importAuthors(string $sourceDirectory): void
    {
        $tableContent = file_get_contents($sourceDirectory.'/lors-authors');

        $rows = explode(PHP_EOL, $tableContent);

        array_pop($rows);

        foreach ($rows as $row) {
            $author = new Author();

            $this->doctrine->persist($author);

            $author->setFullName($row);

            $this->doctrine->flush();
        }
    }

    private function importRecords(string $sourceDirectory): void
    {
        $tableContent = file_get_contents($sourceDirectory.'/lors-bibliographic-records');

        $formattedRows = explode(PHP_EOL, $tableContent);

        array_pop($formattedRows);

        $rows = array_map(function (string $formattedRow): array {
            $rowParts = explode("\t", $formattedRow);

            return [
                'shortName' => $rowParts[0],
                'authors' => $rowParts[1],
                'title' => $rowParts[2],
                'details' => $rowParts[3],
                'year' => (int) $rowParts[4],
            ];
        }, $formattedRows);

        foreach ($rows as $i => $row) {
            $bibliographicRecord = new BibliographicRecord();

            $this->doctrine->persist($bibliographicRecord);

            $bibliographicRecord->setShortName($row['shortName']);
            $bibliographicRecord->setAuthors($row['authors']);
            $bibliographicRecord->setTitle($row['title']);
            $bibliographicRecord->setDetails($row['details']);
            $bibliographicRecord->setYear($row['year']);

            $authorship = new Authorship();

            $authorship->setPosition(0);
            $authorship->setAuthor($this->doctrine->getRepository(Author::class)->find($i + 1));
            $authorship->setBibliographicRecord($bibliographicRecord);

            $bibliographicRecord->setAuthorships(new ArrayCollection([$authorship]));

            $this->doctrine->flush();
        }
    }

    private function bindRecordsToAuthors(string $sourceDirectory): void
    {
        $tableContent = file_get_contents($sourceDirectory.'/lors-letters-literature');

        $rows = explode(PHP_EOL, $tableContent);

        array_pop($rows);

        foreach ($rows as $i => $bibliographicRecordShortName) {
            $letter = $this->letterRepository->find($i + 1);

            $letter->setLiterature(
                [
                    $this->bibliographicRecordRepository->findOneBy([
                        'shortName' => $bibliographicRecordShortName,
                    ]),
                ]
            );

            $this->doctrine->flush();
        }
    }
}
