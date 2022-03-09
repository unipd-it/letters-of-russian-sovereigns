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

namespace App\Admin\Security;

use App\Admin\AbstractEntityAdmin;
use App\Persistence\Entity\Security\User;
use RuntimeException;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserAdmin extends AbstractEntityAdmin
{
    protected $baseRouteName = 'security_user';

    protected $baseRoutePattern = 'security/user';

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        string $code,
        string $class,
        string $baseControllerName,
        UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct($code, $class, $baseControllerName);

        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @param User $object
     */
    public function prePersist(object $object): void
    {
        $this->encodePassword($object);
    }

    /**
     * @param User $object
     */
    public function preUpdate(object $object): void
    {
        $this->encodePassword($object);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->addIdentifier('id', null, $this->createListOptions('id'))
            ->add('username', null, $this->createListOptions('username'))
            ->add('fullName', null, $this->createListOptions('fullName'))
            ->add('roles', null, $this->createListOptions('roles'))
        ;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $isEditForm = $this->isEditForm();

        $formMapper->with($this->getSectionLabel('common'));

        if ($isEditForm) {
            $formMapper
                ->add('id', null, $this->createFormOptions('id', ['required' => true, 'disabled' => true]))
            ;
        }

        $formMapper
            ->add('username', null, $this->createFormOptions('username', ['required' => true]))
            ->add('fullName', null, $this->createFormOptions('fullName', ['required' => true]))
            ->add(
                'roles',
                ChoiceType::class,
                $this->createFormOptions(
                    'roles',
                    [
                        'required' => true,
                        'multiple' => true,
                        'choices' => [
                            'ROLE_USER' => 'ROLE_USER',
                            'ROLE_EDITOR' => 'ROLE_EDITOR',
                            'ROLE_TEXT_EDITOR' => 'ROLE_TEXT_EDITOR',
                            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                        ],
                    ]
                )
            )
            ->add(
                'plainPassword',
                TextType::class,
                $this->createFormOptions('plainPassword', ['required' => !$isEditForm])
            )
        ;

        $formMapper->end();
    }

    private function encodePassword(User $user): void
    {
        if (null !== $user->getPlainPassword()) {
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, $user->getPlainPassword())
            );
        }
    }

    private function isEditForm(): bool
    {
        $file = $this->hasSubject() ? $this->getSubject() : $this->getNewInstance();

        if (!$file instanceof User) {
            throw new RuntimeException('%s error: subject is not instance of %s', __CLASS__, User::class);
        }

        return null !== $file->getId();
    }
}
