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

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(FactoryInterface $factory, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->requestStack = $requestStack;
    }

    public function createMainMenu(array $options): ItemInterface
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');

        $menu = $this->factory->createItem('root')
            ->setChildrenAttribute('class', 'nav flex-column lors-nav')
        ;

        $menu
            ->addChild('page.menu.index', ['route' => 'index'])
        ;

        $menu
            ->addChild('page.menu.dataBase', ['route' => 'letter__list'])
            ->setCurrent(\in_array($currentRoute, ['letter__list', 'letter__show'], true))
        ;

        $menu
            ->addChild('page.menu.bibliography', ['route' => 'bibiliograpic_record__list'])
        ;

        foreach ($menu->getChildren() as $child) {
            $child
                ->setAttribute('class', 'nav-item lors-nav-item')
                ->setLinkAttribute('class', 'nav-link lors-nav-link')
            ;
        }

        return $menu;
    }
}
