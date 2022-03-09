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

namespace App\Admin\Bibliography;

use App\Admin\AbstractEntityAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class BibliographicRecordAdmin extends AbstractEntityAdmin
{
    protected $baseRouteName = 'bibliography_record';

    protected $baseRoutePattern = 'bibliography/bibliographic-record';

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('shortName', null, $this->createListOptions('shortName'))
            ->add('title', null, $this->createListOptions('title'))
            ->add('year', null, $this->createListOptions('year'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->tab($this->getTabLabel('main'))
                ->with($this->getSectionLabel('basicInformation'), ['class' => 'col-md-7'])
                    ->add('shortName', null, $this->createFormOptions('shortName'))
                    ->add('title', null, $this->createFormOptions('title'))
                    ->add('formalNotation', null, $this->createFormOptions('formalNotation'))
                ->end()
                ->with($this->getSectionLabel('filters'), ['class' => 'col-md-5'])
                    ->add('year', null, $this->createFormOptions('year'))
                    ->add('authors', null, $this->createManyToManyFormOptions('authors'))
                ->end()
            ->end()
        ;
    }
}
