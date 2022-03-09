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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="lors__person")
 * @ORM\Entity()
 */
class Person
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
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255, unique=true)
     */
    private $fullName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_sender", type="boolean", options={"default": false})
     */
    private $isSender;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_recipient", type="boolean", options={"default": false})
     */
    private $isRecipient;

    public function __construct()
    {
        $this->isSender = false;
        $this->isRecipient = false;
    }

    public function __toString(): string
    {
        return (string) $this->fullName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIsSender(): bool
    {
        return $this->isSender;
    }

    public function setIsSender(string $isSender): self
    {
        $this->isSender = $isSender;

        return $this;
    }

    public function getIsRecipient(): bool
    {
        return $this->isRecipient;
    }

    public function setIsRecipient(string $isRecipient): self
    {
        $this->isRecipient = $isRecipient;

        return $this;
    }
}
