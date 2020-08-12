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

namespace App\FilterableTable;

use App\Converter\Person\PersonEntityToPersonConverterInterface;
use App\Persistence\Entity\LetterEntity;
use App\Persistence\Entity\PersonEntity;
use Symfony\Component\Routing\RouterInterface;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\FilterConfiguratorInterface;
use Vyfony\Bundle\FilterableTableBundle\Table\Checkbox\CheckboxHandlerInterface;
use Vyfony\Bundle\FilterableTableBundle\Table\Configurator\AbstractTableConfigurator;
use Vyfony\Bundle\FilterableTableBundle\Table\Metadata\Column\ColumnMetadata;
use Vyfony\Bundle\FilterableTableBundle\Table\Metadata\Column\ColumnMetadataInterface;

/**
 * @author Anton Dyshkant <vyshkant@gmail.com>
 */
final class LettersTableConfigurator extends AbstractTableConfigurator
{
    /**
     * @var PersonEntityToPersonConverterInterface
     */
    private $personEntityToPersonConverter;

    public function __construct(
        RouterInterface $router,
        FilterConfiguratorInterface $filterConfigurator,
        string $defaultSortBy,
        string $defaultSortOrder,
        string $listRoute,
        string $showRoute,
        array $showRouteParameters,
        int $pageSize,
        int $paginatorTailLength,
        PersonEntityToPersonConverterInterface $personEntityToPersonConverter
    ) {
        parent::__construct(
            $router,
            $filterConfigurator,
            $defaultSortBy,
            $defaultSortOrder,
            $listRoute,
            $showRoute,
            $showRouteParameters,
            $pageSize,
            $paginatorTailLength
        );

        $this->personEntityToPersonConverter = $personEntityToPersonConverter;
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
        $personFormatter = function (?PersonEntity $personEntity): string {
            if (null === $personEntity) {
                return '';
            }

            return $this
                ->personEntityToPersonConverter
                ->convert($personEntity)
                ->getFullName();
        };

        return [
            (new ColumnMetadata())
                ->setName('id')
                ->setIsIdentifier(true)
                ->setIsSortable(true)
                ->setLabel('controller.letter.list.table.column.id'),
            (new ColumnMetadata())
                ->setName('date')
                ->setValueExtractor(function (LetterEntity $letterEntity): string {
                    return $letterEntity->getDate()->format('Y-m-d');
                })
                ->setIsIdentifier(false)
                ->setIsSortable(false)
                ->setLabel('controller.letter.list.table.column.date'),
            (new ColumnMetadata())
                ->setName('senders')
                ->setValueExtractor(function (LetterEntity $letterEntity) use ($personFormatter): string {
                    return implode(
                        ', ',
                        $letterEntity
                            ->getSenders()
                            ->map($personFormatter)
                            ->toArray()
                    );
                })
                ->setIsIdentifier(false)
                ->setIsSortable(false)
                ->setLabel('controller.letter.list.table.column.senders'),
            (new ColumnMetadata())
                ->setName('recipient')
                ->setValueExtractor(function (LetterEntity $letterEntity) use ($personFormatter): string {
                    return $personFormatter($letterEntity->getRecipient());
                })
                ->setIsIdentifier(false)
                ->setIsSortable(false)
                ->setLabel('controller.letter.list.table.column.recipient'),
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
