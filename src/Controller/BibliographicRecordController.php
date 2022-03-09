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

use App\Persistence\Repository\Bibliography\BibliographicRecordRepository;
use App\Persistence\Repository\Content\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bibliography/record")
 */
final class BibliographicRecordController extends AbstractController
{
    /**
     * @Route("/list", name="bibliographic_record__list", methods={"GET"})
     */
    public function list(
        BibliographicRecordRepository $bibliographicRecordRepository,
        PostRepository $postRepository
    ): Response {
        return $this->render(
            'bibliography/list.html.twig',
            [
                'translationContext' => 'controller.bibliography.list',
                'assetsContext' => 'bibliography/list',
                'post' => $postRepository->findBibliography(),
                'records' => $bibliographicRecordRepository->findAll(),
            ]
        );
    }
}
