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

namespace App\Tests\Wikidata\ResponseMapper;

use App\Wikidata\ResponseMapper\ResponseMapper;
use App\Wikidata\Types\Claim;
use App\Wikidata\Types\DataValue;
use App\Wikidata\Types\LocalizedValue;
use App\Wikidata\Types\Qualifier;
use App\Wikidata\Types\Snak;
use App\Wikidata\Types\WikidataEntity;
use DateTime;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class ResponseMapperTest extends TestCase
{
    /**
     * @var ResponseMapper
     */
    private $responseMapper;

    protected function setUp(): void
    {
        $this->responseMapper = new ResponseMapper();
    }

    /**
     * @dataProvider getEntityDataCollection
     *
     * @param array          $entityData
     * @param WikidataEntity $expectedWikidataEntity
     *
     * @throws Exception
     */
    public function testMap(array $entityData, WikidataEntity $expectedWikidataEntity = null): void
    {
        $wikidataEntity = $this->responseMapper->map($entityData);

        $this->assertEquals($expectedWikidataEntity, $wikidataEntity);
    }

    /**
     * @throws Exception
     *
     * @return array[]
     */
    public function getEntityDataCollection(): array
    {
        return [
            [
                [
                    'pageid' => 9785,
                    'ns' => 0,
                    'title' => 'Q8479',
                    'lastrevid' => 965981210,
                    'modified' => '2019-06-21T04:35:36Z',
                    'type' => 'item',
                    'id' => 'Q8479',
                    'labels' => [
                        'en' => ['language' => 'en', 'value' => 'Peter the Great'],
                        'it' => ['language' => 'it', 'value' => 'Pietro I di Russia'],
                        'en-ca' => ['language' => 'en-ca', 'value' => 'Peter the Great'],
                        'en-gb' => ['language' => 'en-gb', 'value' => 'Peter the Great'],
                        'af' => ['language' => 'af', 'value' => 'Pieter I van Rusland'],
                        'ru' => ['language' => 'ru', 'value' => 'Пётр I'],
                    ],
                    'descriptions' => [
                        'en' => ['language' => 'en', 'value' => '1st Emperor of the Russian Empire'],
                        'it' => ['language' => 'it', 'value' => 'zar e imperatore di Russia'],
                        'ru' => ['language' => 'ru', 'value' => 'первый Император Всероссийский'],
                    ],
                    'aliases' => [
                        'en' => [
                            ['language' => 'en', 'value' => 'Peter I'],
                            ['language' => 'en', 'value' => 'Pyotr Alexeyevich Romanov'],
                            ['language' => 'en', 'value' => 'Pissed off Peter'],
                            ['language' => 'en', 'value' => 'Petr I Alekseevich'],
                        ],
                        'it' => [
                            ['language' => 'it', 'value' => 'Pietro I Romanov'],
                            ['language' => 'it', 'value' => 'Pietro il Grande'],
                            ['language' => 'it', 'value' => 'Romanov, Petr Alekseevich,'],
                        ],
                        'ilo' => [
                            ['language' => 'ilo', 'value' => 'Pedro I'],
                            ['language' => 'ilo', 'value' => 'Pyotr Alexeyevich Romanov'],
                        ],
                        'ru' => [
                            ['language' => 'ru', 'value' => 'Пётр Первый'],
                            ['language' => 'ru', 'value' => 'Пётр I Великий'],
                            ['language' => 'ru', 'value' => 'Пётр I Алексеевич'],
                        ],
                        'be' => [
                            ['language' => 'be', 'value' => 'Пётр I, імператар расійскі'],
                        ],
                        'uk' => [
                            ['language' => 'uk', 'value' => 'Романов, Петр Алексеевич,'],
                        ],
                    ],
                    'claims' => [
                        'P569' => [
                            [
                                'mainsnak' => [
                                    'snaktype' => 'value',
                                    'property' => 'P569',
                                    'datavalue' => [
                                        'value' => [
                                            'time' => '+1672-05-30T00:00:00Z',
                                            'timezone' => 0,
                                            'before' => 0,
                                            'after' => 0,
                                            'precision' => 11,
                                            'calendarmodel' => 'http://www.wikidata.org/entity/Q1985786',
                                        ],
                                        'type' => 'time',
                                    ],
                                    'datatype' => 'time',
                                ],
                                'type' => 'statement',
                                'id' => 'q8479$E5E29594-C338-4D27-9CB9-9FA5220B3058',
                                'rank' => 'normal',
                                'references' => [
                                    [
                                        'hash' => 'fa278ebfc458360e5aed63d5058cca83c46134f1',
                                        'snaks' => [
                                            'P143' => [
                                                [
                                                    'snaktype' => 'value',
                                                    'property' => 'P143',
                                                    'datavalue' => [
                                                        'value' => [
                                                            'entity-type' => 'item',
                                                            'numeric-id' => 328,
                                                            'id' => 'Q328',
                                                        ],
                                                        'type' => 'wikibase-entityid',
                                                    ],
                                                    'datatype' => 'wikibase-item',
                                                ],
                                            ],
                                        ],
                                        'snaks-order' => [
                                            'P143',
                                        ],
                                    ],
                                    [
                                        'hash' => 'abc9457dcf728dd069b8ed5b2e1a86035cf2b679',
                                        'snaks' => [
                                            'P248' => [
                                                [
                                                    'snaktype' => 'value',
                                                    'property' => 'P248',
                                                    'datavalue' => [
                                                        'value' => [
                                                            'entity-type' => 'item',
                                                            'numeric-id' => 36578,
                                                            'id' => 'Q36578',
                                                        ],
                                                        'type' => 'wikibase-entityid',
                                                    ],
                                                    'datatype' => 'wikibase-item',
                                                ],
                                            ],
                                            'P813' => [
                                                [
                                                    'snaktype' => 'value',
                                                    'property' => 'P813',
                                                    'datavalue' => [
                                                        'value' => [
                                                            'time' => '+2014-04-09T00:00:00Z',
                                                            'timezone' => 0,
                                                            'before' => 0,
                                                            'after' => 0,
                                                            'precision' => 11,
                                                            'calendarmodel' => 'http://www.wikidata.org/'.
                                                                'entity/Q1985727',
                                                        ],
                                                        'type' => 'time',
                                                    ],
                                                    'datatype' => 'time',
                                                ],
                                            ],
                                        ],
                                        'snaks-order' => ['P248', 'P813'],
                                    ],
                                ],
                            ],
                        ],
                        'P570' => [
                            [
                                'mainsnak' => [
                                    'snaktype' => 'value',
                                    'property' => 'P570',
                                    'datavalue' => [
                                        'value' => [
                                            'time' => '+1725-01-28T00:00:00Z',
                                            'timezone' => 0,
                                            'before' => 0,
                                            'after' => 0,
                                            'precision' => 11,
                                            'calendarmodel' => 'http://www.wikidata.org/entity/Q1985786',
                                        ],
                                        'type' => 'time',
                                    ],
                                    'datatype' => 'time',
                                ],
                                'type' => 'statement',
                                'id' => 'q8479$B107A0CF-DB37-41C8-B073-9D9462DD3D6D',
                                'rank' => 'normal',
                                'references' => [
                                    [
                                        'hash' => 'fa278ebfc458360e5aed63d5058cca83c46134f1',
                                        'snaks' => [
                                            'P143' => [
                                                [
                                                    'snaktype' => 'value',
                                                    'property' => 'P143',
                                                    'datavalue' => [
                                                        'value' => [
                                                            'entity-type' => 'item',
                                                            'numeric-id' => 328,
                                                            'id' => 'Q328',
                                                        ],
                                                        'type' => 'wikibase-entityid',
                                                    ],
                                                    'datatype' => 'wikibase-item',
                                                ],
                                            ],
                                        ],
                                        'snaks-order' => [
                                            'P143',
                                        ],
                                    ],
                                    [
                                        'hash' => 'abc9457dcf728dd069b8ed5b2e1a86035cf2b679',
                                        'snaks' => [
                                            'P248' => [
                                                [
                                                    'snaktype' => 'value',
                                                    'property' => 'P248',
                                                    'datavalue' => [
                                                        'value' => [
                                                            'entity-type' => 'item',
                                                            'numeric-id' => 36578,
                                                            'id' => 'Q36578',
                                                        ],
                                                        'type' => 'wikibase-entityid',
                                                    ],
                                                    'datatype' => 'wikibase-item',
                                                ],
                                            ],
                                            'P813' => [
                                                [
                                                    'snaktype' => 'value',
                                                    'property' => 'P813',
                                                    'datavalue' => [
                                                        'value' => [
                                                            'time' => '+2014-04-09T00:00:00Z',
                                                            'timezone' => 0,
                                                            'before' => 0,
                                                            'after' => 0,
                                                            'precision' => 11,
                                                            'calendarmodel' => 'http://www.wikidata.org/'.
                                                                'entity/Q1985727',
                                                        ],
                                                        'type' => 'time',
                                                    ],
                                                    'datatype' => 'time',
                                                ],
                                            ],
                                        ],
                                        'snaks-order' => ['P248', 'P813'],
                                    ],
                                ],
                            ],
                        ],
                        'P39' => [
                            [
                                'mainsnak' => [
                                    'snaktype' => 'value',
                                    'property' => 'P39',
                                    'datavalue' => [
                                        'value' => [
                                            'entity-type' => 'item',
                                            'numeric-id' => 2618625,
                                            'id' => 'Q2618625',
                                        ],
                                        'type' => 'wikibase-entityid',
                                    ],
                                    'datatype' => 'wikibase-item',
                                ],
                                'type' => 'statement',
                                'qualifiers' => [
                                    'P580' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P580',
                                            'datavalue' => [
                                                'value' => [
                                                    'time' => '+1721-11-02T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/'.
                                                        'entity/Q1985727',
                                                ],
                                                'type' => 'time',
                                            ],
                                            'datatype' => 'time',
                                        ],
                                    ],
                                    'P582' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P582',
                                            'datavalue' => [
                                                'value' => [
                                                    'time' => '+1725-02-08T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/'.
                                                        'entity/Q1985727',
                                                ],
                                                'type' => 'time',
                                            ],
                                            'datatype' => 'time',
                                        ],
                                    ],
                                    'P1365' => [
                                        [
                                            'snaktype' => 'novalue',
                                            'property' => 'P1365',
                                            'datatype' => 'wikibase-item',
                                        ],
                                    ],
                                    'P1366' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P1366',
                                            'datavalue' => [
                                                'value' => [
                                                    'entity-type' => 'item',
                                                    'numeric-id' => 15208,
                                                    'id' => 'Q15208',
                                                ],
                                                'type' => 'wikibase-entityid',
                                            ],
                                            'datatype' => 'wikibase-item',
                                        ],
                                    ],
                                ],
                                'qualifiers-order' => ['P580', 'P582', 'P1365', 'P1366'],
                                'id' => 'Q8479$62e73c28-4465-8bae-607b-90f365f530d3',
                                'rank' => 'normal',
                            ],
                            [
                                'mainsnak' => [
                                    'snaktype' => 'value',
                                    'property' => 'P39',
                                    'datavalue' => [
                                        'value' => [
                                            'entity-type' => 'item',
                                            'numeric-id' => 60497063,
                                            'id' => 'Q60497063',
                                        ],
                                        'type' => 'wikibase-entityid',
                                    ],
                                    'datatype' => 'wikibase-item',
                                ],
                                'type' => 'statement',
                                'qualifiers' => [
                                    'P580' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P580',
                                            'datavalue' => [
                                                'value' => [
                                                    'time' => '+1682-05-07T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/'.
                                                        'entity/Q1985727',
                                                ],
                                                'type' => 'time',
                                            ],
                                            'datatype' => 'time',
                                        ],
                                    ],
                                    'P582' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P582',
                                            'datavalue' => [
                                                'value' => [
                                                    'time' => '+1721-11-02T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/'.
                                                        'entity/Q1985727',
                                                ],
                                                'type' => 'time',
                                            ],
                                            'datatype' => 'time',
                                        ],
                                    ],
                                    'P1365' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P1365',
                                            'datavalue' => [
                                                'value' => [
                                                    'entity-type' => 'item',
                                                    'numeric-id' => 184868,
                                                    'id' => 'Q184868',
                                                ],
                                                'type' => 'wikibase-entityid',
                                            ],
                                            'datatype' => 'wikibase-item',
                                        ],
                                    ],
                                    'P1366' => [
                                        [
                                            'snaktype' => 'novalue',
                                            'property' => 'P1366',
                                            'datatype' => 'wikibase-item',
                                        ],
                                    ],
                                    'P1706' => [
                                        [
                                            'snaktype' => 'value',
                                            'property' => 'P1706',
                                            'datavalue' => [
                                                'value' => [
                                                    'entity-type' => 'item',
                                                    'numeric-id' => 183698,
                                                    'id' => 'Q183698',
                                                ],
                                                'type' => 'wikibase-entityid',
                                            ],
                                            'datatype' => 'wikibase-item',
                                        ],
                                    ],
                                ],
                                'qualifiers-order' => [
                                    'P580',
                                    'P582',
                                    'P1365',
                                    'P1366',
                                    'P1706',
                                ],
                                'id' => 'Q8479$376e3f3d-451c-cfa9-6a4d-32ddf30e1d72',
                                'rank' => 'normal',
                            ],
                        ],
                        'P1741' => [
                            [
                                'mainsnak' => [
                                    'snaktype' => 'value',
                                    'property' => 'P1741',
                                    'datavalue' => [
                                        'value' => '141364',
                                        'type' => 'string',
                                    ],
                                    'datatype' => 'external-id',
                                ],
                                'type' => 'statement',
                                'id' => 'Q8479$0351DF26-F421-40A0-8CB8-A0719BADA78A',
                                'rank' => 'normal',
                            ],
                        ],
                    ],
                    'sitelinks' => [
                        'afwiki' => [
                            'site' => 'afwiki',
                            'title' => 'Pieter I van Rusland',
                            'badges' => [
                            ],
                            'url' => 'https://af.wikipedia.org/wiki/Pieter_I_van_Rusland',
                        ],
                        'ruwiki' => [
                            'site' => 'ruwiki',
                            'title' => 'Пётр I',
                            'badges' => [
                            ],
                            'url' => 'https://ru.wikipedia.org/wiki/%D0%9F%D1%91%D1%82%D1%80_I',
                        ],
                        'ukwiki' => [
                            'site' => 'ukwiki',
                            'title' => 'Петро I',
                            'badges' => [
                            ],
                            'url' => 'https://uk.wikipedia.org/wiki/%D0%9F%D0%B5%D1%82%D1%80%D0%BE_I',
                        ],
                    ],
                ],
                new WikidataEntity(
                    9785,
                    0,
                    'Q8479',
                    965981210,
                    new DateTime('2019-06-21 04:35:36.000000'),
                    'item',
                    'Q8479',
                    [
                        'en' => new LocalizedValue('en', 'Peter the Great'),
                        'it' => new LocalizedValue('it', 'Pietro I di Russia'),
                        'en-ca' => new LocalizedValue('en-ca', 'Peter the Great'),
                        'en-gb' => new LocalizedValue('en-gb', 'Peter the Great'),
                        'af' => new LocalizedValue('af', 'Pieter I van Rusland'),
                        'ru' => new LocalizedValue('ru', 'Пётр I'),
                    ],
                    [
                        'en' => new LocalizedValue('en', '1st Emperor of the Russian Empire'),
                        'it' => new LocalizedValue('it', 'zar e imperatore di Russia'),
                        'ru' => new LocalizedValue('ru', 'первый Император Всероссийский'),
                    ],
                    [
                        'en' => [
                            new LocalizedValue('en', 'Peter I'),
                            new LocalizedValue('en', 'Pyotr Alexeyevich Romanov'),
                            new LocalizedValue('en', 'Pissed off Peter'),
                            new LocalizedValue('en', 'Petr I Alekseevich'),
                        ],
                        'it' => [
                            new LocalizedValue('it', 'Pietro I Romanov'),
                            new LocalizedValue('it', 'Pietro il Grande'),
                            new LocalizedValue('it', 'Romanov, Petr Alekseevich,'),
                        ],
                        'ilo' => [
                            new LocalizedValue('ilo', 'Pedro I'),
                            new LocalizedValue('ilo', 'Pyotr Alexeyevich Romanov'),
                        ],
                        'ru' => [
                            new LocalizedValue('ru', 'Пётр Первый'),
                            new LocalizedValue('ru', 'Пётр I Великий'),
                            new LocalizedValue('ru', 'Пётр I Алексеевич'),
                        ],
                        'be' => [
                            new LocalizedValue('be', 'Пётр I, імператар расійскі'),
                        ],
                        'uk' => [
                            new LocalizedValue('uk', 'Романов, Петр Алексеевич,'),
                        ],
                    ],
                    [
                        'P569' => [
                            new Claim(
                                new Snak(
                                    'value',
                                    'P569',
                                    'time',
                                    new DataValue(
                                        [
                                            'time' => '+1672-05-30T00:00:00Z',
                                            'timezone' => 0,
                                            'before' => 0,
                                            'after' => 0,
                                            'precision' => 11,
                                            'calendarmodel' => 'http://www.wikidata.org/entity/Q1985786',
                                        ],
                                        'time'
                                    )
                                ),
                                'statement',
                                'q8479$E5E29594-C338-4D27-9CB9-9FA5220B3058',
                                'normal',
                                [],
                                []
                            ),
                        ],
                        'P570' => [
                            new Claim(
                                new Snak(
                                    'value',
                                    'P570',
                                    'time',
                                    new DataValue(
                                        [
                                            'time' => '+1725-01-28T00:00:00Z',
                                            'timezone' => 0,
                                            'before' => 0,
                                            'after' => 0,
                                            'precision' => 11,
                                            'calendarmodel' => 'http://www.wikidata.org/entity/Q1985786',
                                        ],
                                        'time'
                                    )
                                ),
                                'statement',
                                'q8479$B107A0CF-DB37-41C8-B073-9D9462DD3D6D',
                                'normal',
                                [],
                                []
                            ),
                        ],
                        'P39' => [
                            new Claim(
                                new Snak(
                                    'value',
                                    'P39',
                                    'wikibase-item',
                                    new DataValue(
                                        [
                                            'entity-type' => 'item',
                                            'numeric-id' => 2618625,
                                            'id' => 'Q2618625',
                                        ],
                                        'wikibase-entityid'
                                    )
                                ),
                                'statement',
                                'Q8479$62e73c28-4465-8bae-607b-90f365f530d3',
                                'normal',
                                [
                                    'P580' => [
                                        new Qualifier(
                                            'value',
                                            'P580',
                                            'time',
                                            new DataValue(
                                                [
                                                    'time' => '+1721-11-02T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/entity/Q1985727',
                                                ],
                                                'time'
                                            ),
                                            null
                                        ),
                                    ],
                                    'P582' => [
                                        new Qualifier(
                                            'value',
                                            'P582',
                                            'time',
                                            new DataValue(
                                                [
                                                    'time' => '+1725-02-08T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/entity/Q1985727',
                                                ],
                                                'time'
                                            ),
                                            null
                                        ),
                                    ],
                                    'P1365' => [
                                        new Qualifier(
                                            'novalue',
                                            'P1365',
                                            'wikibase-item',
                                            null,
                                            null
                                        ),
                                    ],
                                    'P1366' => [
                                        new Qualifier(
                                            'value',
                                            'P1366',
                                            'wikibase-item',
                                            new DataValue(
                                                [
                                                    'entity-type' => 'item',
                                                    'numeric-id' => 15208,
                                                    'id' => 'Q15208',
                                                ],
                                                'wikibase-entityid'
                                            ),
                                            null
                                        ),
                                    ],
                                ],
                                ['P580', 'P582', 'P1365', 'P1366']
                            ),
                            new Claim(
                                new Snak(
                                    'value',
                                    'P39',
                                    'wikibase-item',
                                    new DataValue(
                                        [
                                            'entity-type' => 'item',
                                            'numeric-id' => 60497063,
                                            'id' => 'Q60497063',
                                        ],
                                        'wikibase-entityid'
                                    )
                                ),
                                'statement',
                                'Q8479$376e3f3d-451c-cfa9-6a4d-32ddf30e1d72',
                                'normal',
                                [
                                    'P580' => [
                                        new Qualifier(
                                            'value',
                                            'P580',
                                            'time',
                                            new DataValue(
                                                [
                                                    'time' => '+1682-05-07T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/entity/Q1985727',
                                                ],
                                                'time'
                                            ),
                                            null
                                        ),
                                    ],
                                    'P582' => [
                                        new Qualifier(
                                            'value',
                                            'P582',
                                            'time',
                                            new DataValue(
                                                [
                                                    'time' => '+1721-11-02T00:00:00Z',
                                                    'timezone' => 0,
                                                    'before' => 0,
                                                    'after' => 0,
                                                    'precision' => 11,
                                                    'calendarmodel' => 'http://www.wikidata.org/entity/Q1985727',
                                                ],
                                                'time'
                                            ),
                                            null
                                        ),
                                    ],
                                    'P1365' => [
                                        new Qualifier(
                                            'value',
                                            'P1365',
                                            'wikibase-item',
                                            new DataValue(
                                                [
                                                    'entity-type' => 'item',
                                                    'numeric-id' => 184868,
                                                    'id' => 'Q184868',
                                                ],
                                                'wikibase-entityid'
                                            ),
                                            null
                                        ),
                                    ],
                                    'P1366' => [
                                        new Qualifier(
                                            'novalue',
                                            'P1366',
                                            'wikibase-item',
                                            null,
                                            null
                                        ),
                                    ],
                                    'P1706' => [
                                        new Qualifier(
                                            'value',
                                            'P1706',
                                            'wikibase-item',
                                            new DataValue(
                                                [
                                                    'entity-type' => 'item',
                                                    'numeric-id' => 183698,
                                                    'id' => 'Q183698',
                                                ],
                                                'wikibase-entityid'
                                            ),
                                            null
                                        ),
                                    ],
                                ],
                                ['P580', 'P582', 'P1365', 'P1366', 'P1706']
                            ),
                        ],
                        'P1741' => [
                            new Claim(
                                new Snak(
                                    'value',
                                    'P1741',
                                    'external-id',
                                    new DataValue(
                                        '141364',
                                        'string'
                                    )
                                ),
                                'statement',
                                'Q8479$0351DF26-F421-40A0-8CB8-A0719BADA78A',
                                'normal',
                                [],
                                []
                            ),
                        ],
                    ],
                    [
                        'afwiki' => [
                            'site' => 'afwiki',
                            'title' => 'Pieter I van Rusland',
                            'badges' => [],
                            'url' => 'https://af.wikipedia.org/wiki/Pieter_I_van_Rusland',
                        ],
                        'ruwiki' => [
                            'site' => 'ruwiki',
                            'title' => 'Пётр I',
                            'badges' => [],
                            'url' => 'https://ru.wikipedia.org/wiki/%D0%9F%D1%91%D1%82%D1%80_I',
                        ],
                        'ukwiki' => [
                            'site' => 'ukwiki',
                            'title' => 'Петро I',
                            'badges' => [],
                            'url' => 'https://uk.wikipedia.org/wiki/%D0%9F%D0%B5%D1%82%D1%80%D0%BE_I',
                        ],
                    ]
                ),
            ],
        ];
    }
}
