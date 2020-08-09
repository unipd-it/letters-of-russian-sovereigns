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

namespace App\Import\RawData;

use App\Import\RawData\Bibliography\RawBibliographyImporterInterface;
use App\Import\RawData\Letters\RawLettersImporterInterface;
use App\Import\RawData\Texts\RawTextsImporterInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class RawDataImporter implements RawDataImporterInterface
{
    /**
     * @var RawLettersImporterInterface
     */
    private $lettersImporter;

    /**
     * @var RawTextsImporterInterface
     */
    private $textsImporter;

    /**
     * @var RawBibliographyImporterInterface
     */
    private $bibliographyImporter;

    public function __construct(
        RawLettersImporterInterface $lettersImporter,
        RawTextsImporterInterface $textsImporter,
        RawBibliographyImporterInterface $bibliographyImporter
    ) {
        $this->lettersImporter = $lettersImporter;
        $this->textsImporter = $textsImporter;
        $this->bibliographyImporter = $bibliographyImporter;
    }

    public function importRawData(string $sourceDirectory): void
    {
        $this->lettersImporter->importLettersData($sourceDirectory);

        $this->textsImporter->importTexts($sourceDirectory);

        $this->bibliographyImporter->importBibliography($sourceDirectory);
    }
}
