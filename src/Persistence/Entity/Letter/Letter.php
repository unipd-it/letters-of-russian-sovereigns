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
 * in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. If you have not received
 * a copy of the GNU General Public License along with
 * «Letters of Russian sovereigns to the Republic of Venice» database,
 * see <http://www.gnu.org/licenses/>.
 */

namespace App\Persistence\Entity\Letter;

use App\Persistence\Entity\Bibliography\BibliographicRecord;
use App\Persistence\Repository\Letter\LetterRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="lors__letter")
 * @ORM\Entity(repositoryClass=LetterRepository::class)
 */
class Letter
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Collection|Person[]
     *
     * @ORM\ManyToMany(targetEntity="App\Persistence\Entity\Letter\Person")
     * @ORM\JoinTable(
     *     name="lors__letter__serder",
     *     joinColumns={@ORM\JoinColumn(name="letter_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="sender_id", referencedColumnName="id")}
     * )
     */
    private $senders;

    /**
     * @var Person|null
     *
     * @ORM\ManyToOne(targetEntity="App\Persistence\Entity\Letter\Person")
     * @ORM\JoinColumn(name="recipient_id")
     */
    private $recipient;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var Collection|BibliographicRecord[]
     *
     * @ORM\ManyToMany(targetEntity="App\Persistence\Entity\Bibliography\BibliographicRecord")
     * @ORM\JoinTable(
     *     name="lors__letter__bibliographic_record",
     *     joinColumns={@ORM\JoinColumn(name="letter_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="bibliographic_record_id", referencedColumnName="id")}
     * )
     */
    private $literature;

    public function __construct()
    {
        $this->senders = new ArrayCollection();
        $this->literature = new ArrayCollection();
    }

    public function __toString(): string
    {
        return null !== $this->date ? $this->date->format('d.m.Y') : '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getSenders(): Collection
    {
        return $this->senders;
    }

    /**
     * @param Collection|Person[] $senders
     */
    public function setSenders(Collection $senders): self
    {
        $this->senders = $senders;

        return $this;
    }

    public function getRecipient(): ?Person
    {
        return $this->recipient;
    }

    public function setRecipient(?Person $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection|BibliographicRecord[]
     */
    public function getLiterature(): Collection
    {
        return $this->literature;
    }

    /**
     * @param Collection|BibliographicRecord[] $literature
     */
    public function setLiterature(Collection $literature): self
    {
        $this->literature = $literature;

        return $this;
    }
}
