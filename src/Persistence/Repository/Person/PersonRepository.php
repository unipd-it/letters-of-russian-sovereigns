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

namespace App\Persistence\Repository\Person;

use App\Converter\Person\PersonEntityToPersonConverterInterface;
use App\Model\Person;
use App\Persistence\Entity\PersonEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class PersonRepository extends ServiceEntityRepository implements PersonRepositoryInterface
{
    /**
     * @var PersonEntityToPersonConverterInterface
     */
    private $personEntityToPersonConverter;

    /**
     * @param RegistryInterface                      $registry
     * @param PersonEntityToPersonConverterInterface $personEntityToPersonConverter
     */
    public function __construct(
        RegistryInterface $registry,
        PersonEntityToPersonConverterInterface $personEntityToPersonConverter
    ) {
        parent::__construct($registry, PersonEntity::class);
        $this->personEntityToPersonConverter = $personEntityToPersonConverter;
    }

    /**
     * @return Person[]
     */
    public function getAll(): array
    {
        return array_map(
            function (PersonEntity $personEntity): Person {
                return $this->personEntityToPersonConverter->convert($personEntity);
            },
            $this->findAll()
        );
    }

    /**
     * @param int $id
     *
     * @return Person
     */
    public function get(int $id): Person
    {
        return $this->personEntityToPersonConverter->convert($this->find($id));
    }
}
