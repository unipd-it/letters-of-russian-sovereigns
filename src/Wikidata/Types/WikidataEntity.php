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

namespace App\Wikidata\Types;

use DateTimeInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class WikidataEntity
{
    /**
     * @var int
     */
    private $pageId;

    /**
     * @var int
     */
    private $namespaceId;

    /**
     * @var string
     */
    private $pageTitle;

    /**
     * @var int
     */
    private $lastRevisionId;

    /**
     * @var DateTimeInterface
     */
    private $lastRevisionTime;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $id;

    /**
     * @var LocalizedValue[]
     */
    private $labels;

    /**
     * @var LocalizedValue[]
     */
    private $descriptions;

    /**
     * @var LocalizedValue[][]
     */
    private $aliases;

    /**
     * @var Claim[][]
     */
    private $claims;

    /**
     * @var SiteLink[]
     */
    private $siteLinks;

    /**
     * @param int                $pageId
     * @param int                $namespaceId
     * @param string             $pageTitle
     * @param int                $lastRevisionId
     * @param DateTimeInterface  $lastRevisionTime
     * @param string             $type
     * @param string             $id
     * @param LocalizedValue[]   $labels
     * @param LocalizedValue[]   $descriptions
     * @param LocalizedValue[][] $aliases
     * @param Claim[][]          $claims
     * @param SiteLink[]         $siteLinks
     */
    public function __construct(
        int $pageId,
        int $namespaceId,
        string $pageTitle,
        int $lastRevisionId,
        DateTimeInterface $lastRevisionTime,
        string $type,
        string $id,
        array $labels,
        array $descriptions,
        array $aliases,
        array $claims,
        array $siteLinks
    ) {
        $this->pageId = $pageId;
        $this->namespaceId = $namespaceId;
        $this->pageTitle = $pageTitle;
        $this->lastRevisionId = $lastRevisionId;
        $this->lastRevisionTime = $lastRevisionTime;
        $this->type = $type;
        $this->id = $id;
        $this->labels = $labels;
        $this->descriptions = $descriptions;
        $this->aliases = $aliases;
        $this->claims = $claims;
        $this->siteLinks = $siteLinks;
    }

    /**
     * @return int
     */
    public function getPageId(): int
    {
        return $this->pageId;
    }

    /**
     * @return int
     */
    public function getNamespaceId(): int
    {
        return $this->namespaceId;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    /**
     * @return int
     */
    public function getLastRevisionId(): int
    {
        return $this->lastRevisionId;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastRevisionTime(): DateTimeInterface
    {
        return $this->lastRevisionTime;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return LocalizedValue[]
     */
    public function getLabels(): array
    {
        return $this->labels;
    }

    /**
     * @return LocalizedValue[]
     */
    public function getDescriptions(): array
    {
        return $this->descriptions;
    }

    /**
     * @return LocalizedValue[][]
     */
    public function getAliases(): array
    {
        return $this->aliases;
    }

    /**
     * @return Claim[][]
     */
    public function getClaims(): array
    {
        return $this->claims;
    }

    /**
     * @return SiteLink[]
     */
    public function getSiteLinks(): array
    {
        return $this->siteLinks;
    }
}
