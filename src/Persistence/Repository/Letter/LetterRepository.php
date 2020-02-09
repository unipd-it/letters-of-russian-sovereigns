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

namespace App\Persistence\Repository\Letter;

use App\Converter\Letter\LetterEntityToLetterConverterInterface;
use App\Model\Letter;
use App\Persistence\Entity\LetterEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class LetterRepository extends ServiceEntityRepository implements LetterRepositoryInterface
{
    /**
     * @var LetterEntityToLetterConverterInterface
     */
    private $letterEntityToLetterConverter;

    public function __construct(
        ManagerRegistry $registry,
        LetterEntityToLetterConverterInterface $letterEntityToLetterConverter
    ) {
        parent::__construct($registry, LetterEntity::class);
        $this->letterEntityToLetterConverter = $letterEntityToLetterConverter;
    }

    /**
     * @return Letter[]
     */
    public function getAll(): array
    {
        return array_map(
            function (LetterEntity $letterEntity): Letter {
                return $this->letterEntityToLetterConverter->convert($letterEntity);
            },
            $this->findAll()
        );
    }

    public function get(int $id): Letter
    {
        return $this->letterEntityToLetterConverter->convert($this->find($id));
    }
}
