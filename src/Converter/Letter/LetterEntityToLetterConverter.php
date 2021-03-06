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

namespace App\Converter\Letter;

use App\Converter\Person\PersonEntityToPersonConverterInterface;
use App\Model\Letter;
use App\Model\Person;
use App\Persistence\Entity\LetterEntity;
use App\Persistence\Entity\PersonEntity;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class LetterEntityToLetterConverter implements LetterEntityToLetterConverterInterface
{
    /**
     * @var PersonEntityToPersonConverterInterface
     */
    private $personEntityToPersonConverter;

    public function __construct(PersonEntityToPersonConverterInterface $personEntityToPersonConverter)
    {
        $this->personEntityToPersonConverter = $personEntityToPersonConverter;
    }

    public function convert(LetterEntity $letterEntity): Letter
    {
        $convertPersonEntityToPerson = function (PersonEntity $personEntity): Person {
            return $this->personEntityToPersonConverter->convert($personEntity);
        };

        return new Letter(
            $letterEntity->getId(),
            $letterEntity->getDate(),
            $letterEntity->getSenders()->map($convertPersonEntityToPerson)->toArray(),
            null !== $letterEntity->getRecipient() ? $convertPersonEntityToPerson($letterEntity->getRecipient()) : null,
            $letterEntity->getText(),
            $letterEntity->getLiterature()->toArray()
        );
    }
}
