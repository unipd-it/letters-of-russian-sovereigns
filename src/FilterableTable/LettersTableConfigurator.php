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

namespace App\FilterableTable;

use App\Persistence\Entity\Letter\Letter;
use App\Persistence\Entity\Letter\Person;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Routing\RouteConfiguration;
use Vyfony\Bundle\FilterableTableBundle\Table\Checkbox\CheckboxHandlerInterface;
use Vyfony\Bundle\FilterableTableBundle\Table\Configurator\AbstractTableConfigurator;
use Vyfony\Bundle\FilterableTableBundle\Table\Metadata\Column\ColumnMetadata;
use Vyfony\Bundle\FilterableTableBundle\Table\Metadata\Column\ColumnMetadataInterface;

final class LettersTableConfigurator extends AbstractTableConfigurator
{
    protected function getListRoute(): RouteConfiguration
    {
        return new RouteConfiguration('letter__list', []);
    }

    /**
     * @param Letter $entity
     */
    protected function getShowRoute($entity): RouteConfiguration
    {
        return new RouteConfiguration(
            'letter__show',
            [
                'id' => $entity->getId(),
            ]
        );
    }

    protected function getSortBy(): string
    {
        return 'id';
    }

    protected function getIsSortAsc(): bool
    {
        return true;
    }

    protected function getPaginatorTailLength(): int
    {
        return 2;
    }

    protected function getResultsCountText(): string
    {
        return 'controller.letter.list.table.resultsCount';
    }

    /**
     * @return ColumnMetadataInterface[]
     */
    protected function createColumnMetadataCollection(): array
    {
        $formatPerson = fn (Person $person): string => $person->getFullName();

        return [
            (new ColumnMetadata())
                ->setIsIdentifier(true)
                ->setName('id')
                ->setLabel('controller.letter.list.table.column.id'),
            (new ColumnMetadata())
                ->setIsIdentifier(false)
                ->setName('date')
                ->setLabel('controller.letter.list.table.column.date')
                ->setValueExtractor(fn (Letter $letter): string => $letter->getDate()->format('d.m.Y')),
            (new ColumnMetadata())
                ->setIsIdentifier(false)
                ->setName('senders')
                ->setLabel('controller.letter.list.table.column.senders')
                ->setValueExtractor(
                    fn (Letter $letter): string => implode(', ', $letter->getSenders()->map($formatPerson)->toArray())
                ),
            (new ColumnMetadata())
                ->setIsIdentifier(false)
                ->setName('recipient')
                ->setLabel('controller.letter.list.table.column.recipient')
                ->setValueExtractor(
                    fn (Letter $letter): string => null !== $letter->getRecipient()
                        ? $formatPerson($letter->getRecipient())
                        : ''
                ),
        ];
    }

    /**
     * @return CheckboxHandlerInterface[]
     */
    protected function createCheckboxHandlers(): array
    {
        return [];
    }
}
