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

namespace App\Converter\Person;

use App\Model\Person;
use App\Model\PositionHeld;
use App\Persistence\Entity\PersonEntity;
use App\Wikidata\Types\Claim;
use App\Wikidata\Types\LocalizedValue;
use App\Wikidata\WikidataConnectorInterface;
use DateTime;
use Exception;
use Symfony\Contracts\Translation\LocaleAwareInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class PersonEntityToPersonConverter implements PersonEntityToPersonConverterInterface
{
    /**
     * @var LocaleAwareInterface
     */
    private $localeProvider;

    /**
     * @var WikidataConnectorInterface
     */
    private $wikidataConnector;

    public function __construct(LocaleAwareInterface $localeProvider, WikidataConnectorInterface $wikidataConnector)
    {
        $this->localeProvider = $localeProvider;
        $this->wikidataConnector = $wikidataConnector;
    }

    /**
     * @throws Exception
     */
    public function convert(PersonEntity $personEntity): Person
    {
        $wikidataEntity = $this->wikidataConnector->getEntity($personEntity->getWikidataItem());

        return new Person(
            $personEntity->getId(),
            $this->peekLocalizedValue($wikidataEntity->getLabels()),
            $this->peekLocalizedValue($wikidataEntity->getDescriptions()),
            new DateTime($wikidataEntity->getClaims()['P569'][0]->getMainSnak()->getDataValue()->getValue()['time']),
            new DateTime($wikidataEntity->getClaims()['P570'][0]->getMainSnak()->getDataValue()->getValue()['time']),
            array_map(
                function (Claim $claim): PositionHeld {
                    return new PositionHeld(
                        $claim->getMainSnak()->getDataValue()->getValue()['id'],
                        \array_key_exists('P580', $claim->getQualifiers())
                            ? new DateTime($claim->getQualifiers()['P580'][0]->getDataValue()->getValue()['time'])
                            : null,
                        \array_key_exists('P582', $claim->getQualifiers())
                            ? new DateTime($claim->getQualifiers()['P582'][0]->getDataValue()->getValue()['time'])
                            : null
                    );
                },
                \array_key_exists('P39', $wikidataEntity->getClaims())
                    ? $wikidataEntity->getClaims()['P39']
                    : []
            )
        );
    }

    /**
     * @param LocalizedValue[] $localizedValues
     */
    private function peekLocalizedValue(array $localizedValues): string
    {
        if (\count($localizedValues) > 0) {
            return $localizedValues[$this->peekLanguage(array_keys($localizedValues))]->getValue();
        }

        return '';
    }

    private function peekLanguage(array $availableLanguages): string
    {
        $languages = [
            $this->localeProvider->getLocale(),
            'en',
            'en-us',
            'en-au',
            'en-gb',
            'en-ca',
            'ru',
            'it',
        ];

        foreach ($languages as $language) {
            if (\in_array($language, $availableLanguages, true)) {
                return $language;
            }
        }

        return $availableLanguages[0];
    }
}
