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

namespace App\FilterableTable\Filter\Parameter;

use App\Persistence\Entity\Letter\Person;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Parameter\ExpressionBuilderInterface;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Parameter\FilterParameterInterface;
use Vyfony\Bundle\FilterableTableBundle\Persistence\QueryBuilder\Alias\AliasFactoryInterface;
use Vyfony\Bundle\FilterableTableBundle\Persistence\QueryBuilder\Parameter\ParameterFactoryInterface;

final class SenderFilterParameter implements FilterParameterInterface, ExpressionBuilderInterface
{
    private ParameterFactoryInterface $parameterFactory;
    private AliasFactoryInterface $aliasFactory;

    public function __construct(ParameterFactoryInterface $parameterFactory, AliasFactoryInterface $aliasFactory)
    {
        $this->parameterFactory = $parameterFactory;
        $this->aliasFactory = $aliasFactory;
    }

    public function getQueryParameterName(): string
    {
        return 'sender';
    }

    public function getType(): string
    {
        return EntityType::class;
    }

    public function getOptions(EntityManager $entityManager): array
    {
        return [
            'label' => 'controller.letter.list.filter.sender',
            'attr' => [
                'class' => '',
                'data-vyfony-filterable-table-filter-parameter' => true,
            ],
            'class' => Person::class,
            'choice_label' => 'fullName',
            'expanded' => false,
            'multiple' => true,
            'query_builder' => $this->createQueryBuilder(),
        ];
    }

    /**
     * @param mixed $formData
     */
    public function buildWhereExpression(QueryBuilder $queryBuilder, $formData, string $entityAlias): ?string
    {
        if (!$formData instanceof Collection || 0 === $formData->count()) {
            return null;
        }

        $ids = $formData->map(fn (Person $entity): int => $entity->getId())->toArray();

        $queryBuilder
            ->innerJoin(
                $entityAlias.'.senders',
                $senderAlias = $this->createAlias()
            )
        ;

        return (string) $queryBuilder->expr()->in($senderAlias.'.id', $ids);
    }

    private function createQueryBuilder(): callable
    {
        return function (EntityRepository $repository): QueryBuilder {
            $parameter = $this->parameterFactory->createNamedParameter('isSender');

            return $repository
                ->createQueryBuilder($entityAlias = $this->createAlias())
                ->where($entityAlias.'.isSender = '.$parameter)
                ->setParameter(substr($parameter, 1), true)
                ->orderBy($entityAlias.'.fullName', 'ASC');
        };
    }

    private function createAlias(): string
    {
        return $this->aliasFactory->createAlias(static::class, 'sender');
    }
}
