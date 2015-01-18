<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Facade;

use Doctrine\ORM\EntityManager;
use SecretBase\AppBundle\Entity\Group;
use SecretBase\AppBundle\Entity\User as EntityUser;
use SecretBase\AppBundle\Response\ErrorResponse;

class User extends Upload
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function quicklyRegisterUser($username, $password, $groupId)
    {
        if ($this->exists($username)) {
            return new ErrorResponse("errors.found.username", ErrorResponse::BAD_REQUEST);
        }

        $user = new EntityUser();
        $user->setUsername($username);
        $user->setPassword($password);

        /** @var Group $group */
        $group = $this->entityManager->getRepository(Group::getClass())->find($groupId);
        $user->addGroup($group);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function exists($username)
    {
        $found = $this->entityManager->getRepository(EntityUser::getClass())->findOneBy(array("username" => $username));
        return !empty($found);
    }
}
