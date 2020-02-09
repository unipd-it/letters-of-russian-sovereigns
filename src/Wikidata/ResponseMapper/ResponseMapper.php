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

namespace App\Wikidata\ResponseMapper;

use App\Wikidata\Types\Claim;
use App\Wikidata\Types\DataValue;
use App\Wikidata\Types\LocalizedValue;
use App\Wikidata\Types\Qualifier;
use App\Wikidata\Types\Snak;
use App\Wikidata\Types\WikidataEntity;
use DateTime;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class ResponseMapper implements ResponseMapperInterface
{
    public function map(array $entityData): WikidataEntity
    {
        $localizedValueMapper = function (array $localizedValueData): LocalizedValue {
            return new LocalizedValue(
                $localizedValueData['language'],
                $localizedValueData['value']
            );
        };

        $dataValueMapper = function (array $dataValueData): DataValue {
            return new DataValue(
                $dataValueData['value'],
                $dataValueData['type']
            );
        };

        $qualifierMapper = function (array $qualifierData) use ($dataValueMapper): Qualifier {
            return new Qualifier(
                $qualifierData['snaktype'],
                $qualifierData['property'],
                $qualifierData['datatype'],
                \array_key_exists('datavalue', $qualifierData)
                    ? $dataValueMapper($qualifierData['datavalue'])
                    : null,
                $qualifierData['hash'] ?? null
            );
        };

        $claimMapper = function (array $claimData) use ($dataValueMapper, $qualifierMapper): Claim {
            return new Claim(
                new Snak(
                    $claimData['mainsnak']['snaktype'],
                    $claimData['mainsnak']['property'],
                    $claimData['mainsnak']['datatype'],
                    $dataValueMapper($claimData['mainsnak']['datavalue'])
                ),
                $claimData['type'],
                $claimData['id'],
                $claimData['rank'],
                \array_key_exists('qualifiers', $claimData)
                    ? array_map(
                        function ($qualifiersDataCollection) use ($qualifierMapper) {
                            return array_map($qualifierMapper, $qualifiersDataCollection);
                        },
                        $claimData['qualifiers']
                    )
                    : [],
                \array_key_exists('qualifiers-order', $claimData) ? $claimData['qualifiers-order'] : []
            );
        };

        return new WikidataEntity(
            $entityData['pageid'],
            $entityData['ns'],
            $entityData['title'],
            $entityData['lastrevid'],
            new DateTime($entityData['modified']),
            $entityData['type'],
            $entityData['id'],
            array_map($localizedValueMapper, $entityData['labels']),
            array_map($localizedValueMapper, $entityData['descriptions']),
            array_map(
                function (array $localizedValueDataCollection) use ($localizedValueMapper): array {
                    return array_map($localizedValueMapper, $localizedValueDataCollection);
                },
                $entityData['aliases']
            ),
            array_map(
                function (array $claimsDataCollection) use ($claimMapper): array {
                    return array_map($claimMapper, $claimsDataCollection);
                },
                $entityData['claims']
            ),
            $entityData['sitelinks']
        );
    }
}
