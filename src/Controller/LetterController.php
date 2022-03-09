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

namespace App\Controller;

use App\Persistence\Entity\Letter\Letter;
use App\Persistence\Repository\Content\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vyfony\Bundle\FilterableTableBundle\Table\TableInterface;

/**
 * @Route("/letter")
 */
final class LetterController extends AbstractController
{
    /**
     * @Route("/list", name="letter__list", methods={"GET"})
     */
    public function list(TableInterface $filterableTable, PostRepository $postRepository): Response
    {
        return $this->render(
            'letter/list.html.twig',
            [
                'translationContext' => 'controller.letter.list',
                'assetsContext' => 'letter/list',
                'post' => $postRepository->findDatabase(),
                'filterForm' => $filterableTable->getFormView(),
                'table' => $filterableTable->getTableMetadata(),
            ]
        );
    }

    /**
     * @Route("/show/{id}", name="letter__show", methods={"GET"})
     */
    public function show(Letter $letter): Response
    {
        return $this->render(
            'letter/show.html.twig',
            [
                'translationContext' => 'controller.letter.show',
                'assetsContext' => 'letter/show',
                'letter' => $letter,
            ]
        );
    }
}
