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

use App\FilterableTable\Filter\Parameter\RecipientFilterParameter;
use App\FilterableTable\Filter\Parameter\SenderFilterParameter;
use App\FilterableTable\Filter\Parameter\TextFilterParameter;
use App\Persistence\Entity\Letter\Letter;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\AbstractFilterConfigurator;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Parameter\FilterParameterInterface;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Parameter\Table\TableParameterInterface;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Restriction\FilterRestrictionInterface;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Sorting\CustomSortConfiguration;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Sorting\CustomSortConfigurationInterface;
use Vyfony\Bundle\FilterableTableBundle\Filter\Configurator\Sorting\DbSortConfigurationInterface;

final class LettersFilterConfigurator extends AbstractFilterConfigurator
{
    private TextFilterParameter $textFilterParameter;
    private SenderFilterParameter $senderFilterParameter;
    private RecipientFilterParameter $recipientFilterParameter;

    public function __construct(
        TextFilterParameter $textFilterParameter,
        SenderFilterParameter $senderFilterParameter,
        RecipientFilterParameter $recipientFilterParameter
    ) {
        $this->textFilterParameter = $textFilterParameter;
        $this->senderFilterParameter = $senderFilterParameter;
        $this->recipientFilterParameter = $recipientFilterParameter;
    }

    public function createSubmitButtonOptions(): array
    {
        return [
            'attr' => ['class' => 'btn lors-btn lors-btn-dark'],
            'label' => 'controller.letter.list.filter.controls.submitButton',
        ];
    }

    public function createResetButtonOptions(): array
    {
        return [
            'attr' => ['class' => 'btn lors-btn lors-btn-light'],
            'label' => 'controller.letter.list.filter.controls.resetButton',
        ];
    }

    public function createSearchInFoundButtonOptions(): array
    {
        return [
            'attr' => ['class' => 'btn lors-btn lors-btn-very-light'],
            'label' => 'controller.letter.list.filter.controls.searchInFoundButton',
        ];
    }

    public function createDefaults(): array
    {
        return [
            'label_attr' => ['class' => ''],
            'translation_domain' => 'messages',
            'attr' => ['class' => 'row'],
            'method' => 'GET',
            'csrf_protection' => false,
            'required' => false,
        ];
    }

    /**
     * @param Letter $entity
     */
    public function getEntityId($entity): int
    {
        return (int) $entity->getId();
    }

    /**
     * @return FilterRestrictionInterface[]
     */
    protected function createFilterRestrictions(): array
    {
        return [];
    }

    /**
     * @return FilterParameterInterface[]
     */
    protected function createFilterParameters(): array
    {
        return [
            $this->senderFilterParameter,
            $this->recipientFilterParameter,
            $this->textFilterParameter,
        ];
    }

    /**
     * @return TableParameterInterface[]
     */
    protected function createTableParameters(): array
    {
        return [];
    }

    protected function createDbSortConfiguration(): ?DbSortConfigurationInterface
    {
        return null;
    }

    protected function createCustomSortConfiguration(): ?CustomSortConfigurationInterface
    {
        return new CustomSortConfiguration(
            function (array $documents): array {
                usort($documents, fn (Letter $a, Letter $b): int => $a->getId() > $b->getId() ? 1 : -1);

                return $documents;
            }
        );
    }
}
