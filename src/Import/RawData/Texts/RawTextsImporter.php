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

namespace App\Import\RawData\Texts;

use App\Persistence\Repository\Letter\LetterRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class RawTextsImporter implements RawTextsImporterInterface
{
    /**
     * @var LetterRepository
     */
    private $letterRepository;

    /**
     * @var EntityManagerInterface
     */
    private $doctrine;

    /**
     * @var array[]
     */
    private $symbolsMapByThesis = [
        1 => [
            '%' => 'ꙋ',
            '' => 'ꙋ',
            '' => 'Ѡ',
            '8' => 'ѡ',
            '' => 'ѧ',
            '6' => 'ѯ',
            'ý' => 'ѣ',
            'ÿ' => 'ꙗ',
            'i' => 'і',
            'É' => 'І',
            'å' => 'є',
            'ß' => 'Ꙗ',
            'A' => 'А',
            'a' => 'а',
            'С' => 'С',
            'c' => 'с',
            'E' => 'Е',
            'e' => 'е',
            'y' => 'у',
            'o' => 'о',
            'P' => 'Р',
            'h' => 'х',
            'Õ' => 'Х',
            'õ' => 'х',
            'χ' => 'х',
            'f' => 'ф',
            '0' => 'ѧ',
            '7' => 'Ѕ',
            '¬' => 'ѧ',
            '' => 'ꙗ',
            '9' => 'ѳ',
            '' => 'ф',
            'ô' => 'ф',
            'H' => 'Х',
            'u' => 'ѹ',
            '‡' => '҂',
        ],
        2 => [
            '' => 'ꙋ',
            '' => 'ѣ',
            'i' => 'і',
            'I' => 'І',
            '' => 'І',
            '' => 'ѡ',
            '' => 'ѯ',
            '' => 'ѕ',
            '' => 'ѳ',
            '' => 'Ѳ',
            'C' => 'С',
            'a' => 'а',
        ],
        3 => [
            '' => 'ꙋ',
            '' => 'ѣ',
            'i' => 'і',
            'I' => 'І',
            '' => 'ѡ',
            '' => 'ѯ',
            '' => 'ѳ',
            '' => 'Ѳ',
            'c' => 'с',
            'a' => 'а',
            'e' => 'е',
            '' => 'ꙗ',
            'S' => 'Ѕ',
        ],
        4 => [
            '' => 'ѣ',
            '' => 'ꙋ',
            '' => 'ѯ',
            '' => 'ѡ',
            '' => 'ѕ',
            '' => 'ѳ',
            '' => 'ф',
            '%' => 'ꙋ',
            '' => 'Ꙗ',
            'i' => 'і',
            'I' => 'І',
            '' => 'ꙗ',
            '' => ' ',
            '' => 'Ф',
            'c' => 'с',
            'C' => 'С',
            'o' => 'о',
        ],
        5 => [
            '' => 'ѣ',
            '' => 'ꙋ',
            '' => 'ѳ',
            '' => 'ѳ',
            '' => 'ѡ',
            '' => 'ѕ',
            '' => 'ѯ',
            '%' => 'ꙋ',
            '' => 'ꙗ',
            'i' => 'і',
            'I' => 'І',
            'e' => 'е',
            'E' => 'Е',
            'a' => 'а',
            'A' => 'А',
            'y' => 'у',
            'c' => 'с',
            'C' => 'С',
            'p' => 'р',
            'P' => 'Р',
            'o' => 'о',
            'H' => 'Н',
            'M' => 'М',
            '§' => 'ѳ',
            'T' => 'Т',
            '' => 'Ꙗ',
            'ý' => 'ѣ',
        ],
        6 => [
            '' => 'ѣ',
            '' => 'ꙋ',
            '' => 'ѡ',
            'i' => 'і',
            'I' => 'І',
            '' => '.',
            'a' => 'а',
            'e' => 'е',
        ],
        7 => [
            '' => 'ѣ',
            '' => 'ꙋ',
            'i' => 'і',
            '' => ' ',
            'c' => 'с',
        ],
    ];

    public function __construct(
        LetterRepository $letterRepository,
        EntityManagerInterface $doctrine
    ) {
        $this->letterRepository = $letterRepository;
        $this->doctrine = $doctrine;
    }

    public function importTexts(string $sourceDirectory): void
    {
        $allLetters =
            $this->importThesis($sourceDirectory, 1, 1, true) +
            $this->importThesis($sourceDirectory, 2, 14, true) +
            $this->importThesis($sourceDirectory, 3, 17, false) +
            $this->importThesis($sourceDirectory, 4, 21, true) +
            $this->importThesis($sourceDirectory, 5, 31, true) +
            $this->importThesis($sourceDirectory, 6, 44, true) +
            $this->importThesis($sourceDirectory, 7, 55, true);

        $this->writeFile($allLetters, $sourceDirectory.'/all-texts');
    }

    private function importThesis(
        string $sourceDirectory,
        int $thesisIndex,
        int $firstLetterId,
        bool $usingRightRowIndexes
    ): array {
        $sourceFileName = $sourceDirectory.'/thesis'.$thesisIndex;
        $destinationFileName = $sourceFileName.'-final';

        $fileContent = $this->readFile($sourceFileName);

        $lettersById = $this->parseLetters($fileContent, $firstLetterId);

        $finalLetters = $this->applyAllTheMappings($lettersById, $thesisIndex, $usingRightRowIndexes);

        $this->writeFile($finalLetters, $destinationFileName);

        $this->updateDb($finalLetters);

        return $finalLetters;
    }

    private function readFile(string $fileName): string
    {
        return file_get_contents($fileName);
    }

    private function writeFile(array $lettersById, string $fileName): void
    {
        array_walk($lettersById, function (string &$letter, int $letterId): void {
            $letter = sprintf('[Письмо %d]%s%s', $letterId, PHP_EOL.PHP_EOL, $letter);
        });

        file_put_contents($fileName, implode($lettersById, PHP_EOL.PHP_EOL));
    }

    private function parseLetters(string $fileContent, int $firstLetterId): array
    {
        $rows = preg_split('/\(Письмо [0-9]+\)/um', $fileContent);

        array_shift($rows);

        $trimmedRows = array_map(function (string $row): string {
            return trim($row, PHP_EOL);
        }, $rows);

        $letterIds = range($firstLetterId, $firstLetterId + \count($trimmedRows) - 1);

        return array_combine($letterIds, $trimmedRows);
    }

    private function applyAllTheMappings(array $lettersById, int $thesisIndex, bool $usingRightRowIndexes): array
    {
        $lettersByIdWithNormalizedPipes = array_map(
            [$this, 'normalisePipes'],
            $lettersById
        );

        $lettersByIdWithRemovedRowIndexes = array_map(
            $usingRightRowIndexes ? [$this, 'removeRightRowIndexes'] : [$this, 'removeLeftRowIndexes'],
            $lettersByIdWithNormalizedPipes
        );

        $lettersByIdWithLineBreaks = array_map(
            [$this, 'convertRowSeparatorsToLineBreaks'],
            $lettersByIdWithRemovedRowIndexes
        );

        $lettersCorrectUnderscores = array_map(
            [$this, 'removeBrokenAsterisks'],
            $lettersByIdWithLineBreaks
        );

        $lettersByIdWithTrimmedLines = array_map(
            [$this, 'trimRows'],
            $lettersCorrectUnderscores
        );

        $lettersByIdWithRemovedDoubleSpaces = array_map(
            [$this, 'removeDoubleSpaces'],
            $lettersByIdWithTrimmedLines
        );

        $lettersByIdWithRemovedDoubleBlankLines = array_map(
            [$this, 'removeDoubleBlankLines'],
            $lettersByIdWithRemovedDoubleSpaces
        );

        $lettersByIdWithReplacedSymbols = array_map(
            function (string $letter) use ($thesisIndex): string {
                return $this->replaceSymbols($letter, $this->symbolsMapByThesis[$thesisIndex]);
            },
            $lettersByIdWithRemovedDoubleBlankLines
        );

        $lettersWithAccents = array_map(
            [$this, 'replaceAsteriskWithAccentSign'],
            $lettersByIdWithReplacedSymbols
        );

        $lettersRemovedSpaceAfterThousands = array_map(
            [$this, 'removeSpacesAfterThousand'],
            $lettersWithAccents
        );

        $lettersWithFixedXml = array_map(
            [$this, 'fixXml'],
            $lettersRemovedSpaceAfterThousands
        );

        return $lettersWithFixedXml;
    }

    private function updateDb(array $lettersWithAccents): void
    {
        foreach ($lettersWithAccents as $letterId => $letterText) {
            $this->letterRepository->find($letterId)->setText($letterText);
        }

        $this->doctrine->flush();
    }

    private function normalisePipes(string $letter): string
    {
        return str_replace('|‌‌‌', '|', $letter);
    }

    private function removeRightRowIndexes(string $letter): string
    {
        return preg_replace('/\|\d*[05]/um', '|', $letter);
    }

    private function removeLeftRowIndexes(string $letter): string
    {
        return preg_replace('/\d*[05]\|/um', '|', $letter);
    }

    private function convertRowSeparatorsToLineBreaks(string $letter): string
    {
        return str_replace('|', PHP_EOL, $letter);
    }

    private function trimRows(string $letter): string
    {
        return implode(PHP_EOL, array_map('trim', explode(PHP_EOL, $letter)));
    }

    private function removeBrokenAsterisks(string $letter): string
    {
        return str_replace(
            ' *',
            ' ',
            $letter
        );
    }

    private function removeDoubleSpaces(string $letter): string
    {
        $search = '  ';

        while (false !== mb_strpos($letter, $search)) {
            $letter = str_replace($search, ' ', $letter);
        }

        return $letter;
    }

    private function removeDoubleBlankLines(string $letter): string
    {
        $search = PHP_EOL.PHP_EOL.PHP_EOL;

        while (false !== mb_strpos($letter, $search)) {
            $letter = str_replace($search, PHP_EOL.PHP_EOL, $letter);
        }

        return $letter;
    }

    private function replaceSymbols(string $letter, array $symbolsMap): string
    {
        return str_replace(
            array_keys($symbolsMap),
            array_values($symbolsMap),
            $letter
        );
    }

    private function replaceAsteriskWithAccentSign(string $letter): string
    {
        return str_replace(
            '*',
            '́',
            $letter
        );
    }

    private function removeSpacesAfterThousand(string $letter): string
    {
        return str_replace(
            '҂ ',
            '҂',
            $letter
        );
    }

    private function fixXml(string $letter): string
    {
        return str_replace(
            [
                0 => 'supеr>',
                1 => 'sѹpеr>',
                2 => 'suреr>',
                3 => ' </super>',
                4 => '<super></super>',
                5 => PHP_EOL.'</super>',
            ],
            [
                0 => 'super>',
                1 => 'super>',
                2 => 'super>',
                3 => '</super>',
                4 => '',
                5 => '</super>'.PHP_EOL,
            ],
            $letter
        );
    }
}
