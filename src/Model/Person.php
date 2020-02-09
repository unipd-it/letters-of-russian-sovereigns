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

namespace App\Model;

use DateTimeInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class Person
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $fullName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var DateTimeInterface
     */
    private $dateOfBirth;

    /**
     * @var DateTimeInterface
     */
    private $dateOfDeath;

    /**
     * @var PositionHeld[]
     */
    private $positionsHeld;

    /**
     * @param PositionHeld[] $positionsHeld
     */
    public function __construct(
        int $id,
        string $fullName,
        string $description,
        DateTimeInterface $dateOfBirth,
        DateTimeInterface $dateOfDeath,
        array $positionsHeld
    ) {
        $this->id = $id;
        $this->fullName = $fullName;
        $this->description = $description;
        $this->dateOfBirth = $dateOfBirth;
        $this->dateOfDeath = $dateOfDeath;
        $this->positionsHeld = $positionsHeld;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDateOfBirth(): DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function getDateOfDeath(): DateTimeInterface
    {
        return $this->dateOfDeath;
    }

    /**
     * @return PositionHeld[]
     */
    public function getPositionsHeld(): array
    {
        return $this->positionsHeld;
    }
}
