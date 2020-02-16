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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vyfony\Bundle\BibliographyBundle\Persistence\Entity\BibliographicRecord;

/**
 * @ORM\Entity(repositoryClass="App\Persistence\Repository\Letter\LetterRepository")
 * @ORM\Table(name="lors__letter")
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Collection|PersonEntity[]
     *
     * @ORM\ManyToMany(targetEntity="App\Persistence\Entity\PersonEntity")
     * @ORM\JoinTable(
     *     name="lors__letter_serder",
     *     joinColumns={@ORM\JoinColumn(name="letter_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="sender_id", referencedColumnName="id")}
     * )
     */
    private $senders;

    /**
     * @var PersonEntity|null
     *
     * @ORM\ManyToOne(targetEntity="App\Persistence\Entity\PersonEntity")
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
     * @ORM\ManyToMany(targetEntity="Vyfony\Bundle\BibliographyBundle\Persistence\Entity\BibliographicRecord")
     * @ORM\JoinTable(
     *     name="lors__letter_bibliographic_record",
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @return LetterEntity
     */
    public function setDate(DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|PersonEntity[]
     */
    public function getSenders(): Collection
    {
        return $this->senders;
    }

    /**
     * @param iterable|PersonEntity[] $senders
     */
    public function setSenders(iterable $senders): self
    {
        $this->senders = new ArrayCollection();

        foreach ($senders as $sender) {
            $this->senders->add($sender);
        }

        return $this;
    }

    public function getRecipient(): ?PersonEntity
    {
        return $this->recipient;
    }

    public function setRecipient(?PersonEntity $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @return LetterEntity
     */
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
     * @param iterable|BibliographicRecord[] $literature
     */
    public function setLiterature(iterable $literature): self
    {
        $this->literature = new ArrayCollection();

        foreach ($literature as $bibliographicRecord) {
            $this->literature->add($bibliographicRecord);
        }

        return $this;
    }
}
