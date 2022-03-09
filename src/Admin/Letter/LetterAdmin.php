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

namespace App\Admin\Letter;

use App\Admin\AbstractEntityAdmin;
use Knp\Menu\ItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\DateType;

final class LetterAdmin extends AbstractEntityAdmin
{
    protected $baseRouteName = 'letter_letter';

    protected $baseRoutePattern = 'letter/letter';

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('id', null, $this->createListOptions('id'))
            ->add('date', null, $this->createListOptions('date'))
            ->add('senders', null, $this->createListOptions('senders'))
            ->add('recipient', null, $this->createListOptions('recipient'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->tab($this->getTabLabel('basicInformation'))
                ->with($this->getSectionLabel('metadata'), ['class' => 'col-md-6'])
                    ->add('date', DateType::class, $this->createFormOptions('date', ['widget' => 'single_text']))
                    ->add('senders', null, $this->createManyToManyFormOptions('senders'))
                    ->add('recipient', null, $this->createFormOptions('recipient'))
                ->end()
                ->with($this->getSectionLabel('text'), ['class' => 'col-md-6'])
                    ->add('text', null, $this->createFormOptions('text'))
                ->end()
            ->end()
            ->tab($this->getTabLabel('sources'))
                ->with($this->getSectionLabel('sources'))
                    ->add('literature', null, $this->createManyToManyFormOptions('literature'))
                ->end()
            ->end()
        ;
    }

    protected function configureTabMenu(ItemInterface $menu, string $action, AdminInterface $childAdmin = null): void
    {
        if ('edit' === $action || null !== $childAdmin) {
            $admin = $this->isChild() ? $this->getParent() : $this;

            if ((null !== $letter = $this->getSubject()) && (null !== $letter->getId())) {
                $menu->addChild(
                    'tabMenu.letter.viewOnSite',
                    [
                        'uri' => $admin->getRouteGenerator()->generate(
                            'letter__show',
                            [
                                'id' => $letter->getId(),
                            ]
                        ),
                        'linkAttributes' => [
                            'target' => '_blank',
                        ],
                    ]
                );
            }
        }
    }
}
