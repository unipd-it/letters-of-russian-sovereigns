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
use Vyfony\Bundle\BibliographyBundle\Persistence\Entity\BibliographicRecord;

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
     * @var Person[]
     */
    private $senders;

    /**
     * @var Person|null
     */
    private $recipient;

    /**
     * @var string
     */
    private $text;

    /**
     * @var BibliographicRecord[]
     */
    private $literature;

    /**
     * @param Person[]              $senders
     * @param BibliographicRecord[] $literature
     */
    public function __construct(
        int $id,
        DateTimeInterface $date,
        array $senders,
        ?Person $recipient,
        string $text,
        array $literature
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->senders = $senders;
        $this->recipient = $recipient;
        $this->text = $text;
        $this->literature = $literature;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return Person[]
     */
    public function getSenders(): array
    {
        return $this->senders;
    }

    public function getRecipient(): ?Person
    {
        return $this->recipient;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return BibliographicRecord[]
     */
    public function getLiterature(): array
    {
        return $this->literature;
    }
}
