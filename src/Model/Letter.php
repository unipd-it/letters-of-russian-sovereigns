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
final class Letter
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTimeInterface
     */
    private $date;

    /**
     * @var Person
     */
    private $sender;

    /**
     * @var Person
     */
    private $recipient;

    /**
     * @var string
     */
    private $text;

    /**
     * @param int               $id
     * @param DateTimeInterface $date
     * @param Person            $sender
     * @param Person            $recipient
     * @param string            $text
     */
    public function __construct(int $id, DateTimeInterface $date, Person $sender, Person $recipient, string $text)
    {
        $this->id = $id;
        $this->date = $date;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return Person
     */
    public function getSender(): Person
    {
        return $this->sender;
    }

    /**
     * @return Person
     */
    public function getRecipient(): Person
    {
        return $this->recipient;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
