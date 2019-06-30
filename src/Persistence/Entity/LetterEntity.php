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

namespace App\Persistence\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Persistence\Repository\Letter\LetterRepository")
 *
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
class LetterEntity
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var PersonEntity
     *
     * @ORM\ManyToOne(targetEntity="App\Persistence\Entity\PersonEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @var PersonEntity
     *
     * @ORM\ManyToOne(targetEntity="App\Persistence\Entity\PersonEntity")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $text;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     *
     * @return LetterEntity
     */
    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return PersonEntity|null
     */
    public function getSender(): ?PersonEntity
    {
        return $this->sender;
    }

    /**
     * @param PersonEntity $sender
     *
     * @return LetterEntity
     */
    public function setSender(PersonEntity $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return PersonEntity|null
     */
    public function getRecipient(): ?PersonEntity
    {
        return $this->recipient;
    }

    /**
     * @param PersonEntity $recipient
     *
     * @return LetterEntity
     */
    public function setRecipient(PersonEntity $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return LetterEntity
     */
    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
