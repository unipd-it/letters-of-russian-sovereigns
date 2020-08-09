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

namespace App\Import\RawData\Letters;

use App\Persistence\Entity\LetterEntity;
use App\Persistence\Entity\PersonEntity;
use App\Persistence\Repository\Person\PersonRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class RawLettersImporter implements RawLettersImporterInterface
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    public function __construct(
        PersonRepository $personRepository,
        EntityManagerInterface $doctrine
    ) {
        $this->personRepository = $personRepository;
        $this->doctrine = $doctrine;
    }

    public function importLettersData(string $sourceDirectory): void
    {
        $tableContent = file_get_contents($sourceDirectory.'/lors-letters');

        $formattedRows = explode(PHP_EOL, $tableContent);

        array_pop($formattedRows);

        $rows = array_map(function (string $formattedRow): array {
            $rowParts = explode("\t", $formattedRow);

            return [
                'date' => new DateTime($rowParts[0]),
                'senders' => explode(', ', $rowParts[1]),
                'recipient' => '' === $rowParts[2] ? null : $rowParts[2],
            ];
        }, $formattedRows);

        foreach ($rows as $row) {
            $letter = new LetterEntity();

            $this->doctrine->persist($letter);

            $letter->setDate($row['date']);
            $letter->setSenders(array_map([$this, 'getPersonEntity'], $row['senders']));
            $letter->setRecipient(null !== $row['recipient'] ? $this->getPersonEntity($row['recipient']) : null);
            $letter->setText('');

            $this->doctrine->flush();
        }
    }

    private function getPersonEntity(string $wikidataItem): PersonEntity
    {
        $personEntity = $this->personRepository->findOneBy([
            'wikidataItem' => $wikidataItem,
        ]);

        if (null === $personEntity) {
            $personEntity = new PersonEntity();

            $personEntity->setWikidataItem($wikidataItem);

            $this->doctrine->persist($personEntity);

            $this->doctrine->flush();
        }

        return $personEntity;
    }
}
