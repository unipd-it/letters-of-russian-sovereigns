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

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class Claim
{
    /**
     * @var Snak
     */
    private $mainSnak;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $rank;

    /**
     * @var Qualifier[][]
     */
    private $qualifiers;

    /**
     * @var string[]
     */
    private $qualifiersOrder;

    /**
     * @param Qualifier[][] $qualifiers
     * @param string[]      $qualifiersOrder
     */
    public function __construct(
        Snak $mainSnak,
        string $type,
        string $id,
        string $rank,
        array $qualifiers,
        array $qualifiersOrder
    ) {
        $this->mainSnak = $mainSnak;
        $this->type = $type;
        $this->id = $id;
        $this->rank = $rank;
        $this->qualifiers = $qualifiers;
        $this->qualifiersOrder = $qualifiersOrder;
    }

    public function getMainSnak(): Snak
    {
        return $this->mainSnak;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * @return Qualifier[][]
     */
    public function getQualifiers(): array
    {
        return $this->qualifiers;
    }

    /**
     * @return string[]
     */
    public function getQualifiersOrder(): array
    {
        return $this->qualifiersOrder;
    }
}
