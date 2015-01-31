<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use FOS\UserBundle\Model\UserManagerInterface;
use SecretBase\AppBundle\Entity\User;

class UserManager extends ORMManager
{
    /** @var UserManagerInterface */
    private $fosUserManager;

    public function __construct($em, $fosUserManager)
    {
        parent::__construct($em, User::getClass());
        $this->fosUserManager = $fosUserManager;
    }

    /**
     * @return User
     */
    public function create()
    {
        return $this->fosUserManager->createUser();
    }

    /**
     * @param User $user
     * @param bool $flush
     */
    public function persist(User $user, $flush = true)
    {
        $this->fosUserManager->updateUser($user, $flush);
    }
}
