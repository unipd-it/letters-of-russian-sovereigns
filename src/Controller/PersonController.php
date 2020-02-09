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

namespace App\Controller;

use App\Persistence\Repository\Person\PersonRepositoryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/person")
 *
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class PersonController extends AbstractController
{
    /**
     * @var PersonRepositoryInterface
     */
    private $personRepository;

    public function __construct(PersonRepositoryInterface $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    /**
     * @Route("/list", name="person__list", methods={"GET"})
     * @Template("person/list.html.twig")
     */
    public function list(): array
    {
        return [
            'controller' => 'person',
            'method' => 'list',
            'people' => $this->personRepository->getAll(),
        ];
    }

    /**
     * @Route("/show/{id}", name="person__show", methods={"GET"})
     * @Template("person/show.html.twig")
     */
    public function show(int $id): array
    {
        return [
            'controller' => 'person',
            'method' => 'show',
            'person' => $this->personRepository->get($id),
        ];
    }
}
