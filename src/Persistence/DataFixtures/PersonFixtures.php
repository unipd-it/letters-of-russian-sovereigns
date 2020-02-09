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

namespace App\Persistence\DataFixtures;

use App\Persistence\Entity\PersonEntity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class PersonFixtures extends Fixture
{
    public const PETER_THE_GREAT = 'peter_the_great';

    public const ALVISE_II_MOCENIGO = 'alvise_ii_mocenigo';

    public function load(ObjectManager $manager): void
    {
        $person = (new PersonEntity())
            ->setWikidataItem('Q8479')
        ;
        $this->setReference(self::PETER_THE_GREAT, $person);
        $manager->persist($person);

        $person = (new PersonEntity())
            ->setWikidataItem('Q132292')
        ;
        $this->setReference(self::ALVISE_II_MOCENIGO, $person);
        $manager->persist($person);

        $manager->flush();
    }
}
