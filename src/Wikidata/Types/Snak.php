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
class Snak
{
    /**
     * @var string
     */
    private $snakType;

    /**
     * @var string
     */
    private $property;

    /**
     * @var string
     */
    private $dataType;

    /**
     * @var DataValue|null
     */
    private $dataValue;

    public function __construct(string $snakType, string $property, string $dataType, ?DataValue $dataValue)
    {
        $this->snakType = $snakType;
        $this->property = $property;
        $this->dataType = $dataType;
        $this->dataValue = $dataValue;
    }

    public function getSnakType(): string
    {
        return $this->snakType;
    }

    public function getProperty(): string
    {
        return $this->property;
    }

    public function getDataType(): string
    {
        return $this->dataType;
    }

    public function getDataValue(): DataValue
    {
        return $this->dataValue;
    }
}
