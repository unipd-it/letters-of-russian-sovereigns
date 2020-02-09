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
final class PositionHeld
{
    /**
     * @var string
     */
    private $positionName;

    /**
     * @var DateTimeInterface
     */
    private $startTime;

    /**
     * @var DateTimeInterface
     */
    private $endTime;

    public function __construct(string $positionName, DateTimeInterface $startTime, DateTimeInterface $endTime)
    {
        $this->positionName = $positionName;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getPositionName(): string
    {
        return $this->positionName;
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->startTime;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->endTime;
    }
}
