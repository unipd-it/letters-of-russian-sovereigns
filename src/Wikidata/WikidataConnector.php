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

namespace App\Wikidata;

use App\Wikidata\ResponseMapper\ResponseMapperInterface;
use App\Wikidata\Types\WikidataEntity;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class WikidataConnector implements WikidataConnectorInterface
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var ResponseMapperInterface
     */
    private $responseMapper;

    /**
     * @param ClientInterface         $client
     * @param ResponseMapperInterface $responseMapper
     */
    public function __construct(ClientInterface $client, ResponseMapperInterface $responseMapper)
    {
        $this->client = $client;
        $this->responseMapper = $responseMapper;
    }

    /**
     * @param string $entityId
     *
     * @throws GuzzleException
     *
     * @return WikidataEntity
     */
    public function getEntity(string $entityId): WikidataEntity
    {
        $url = $this->createUrl($entityId);

        $formattedResponse = (string) $this->client->request('GET', new Uri($url))->getBody();

        $response = json_decode($formattedResponse, true);

        return $this->responseMapper->map($response['entities'][$entityId]);
    }

    /**
     * @param string $entityId
     *
     * @return string
     */
    private function createUrl(string $entityId): string
    {
        return sprintf('http://www.wikidata.org/wiki/Special:EntityData/%s.json', $entityId);
    }
}
