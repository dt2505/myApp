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

class UserManager extends ORManager
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
     * {@inheritdoc}
     */
    public function persist($user, $flush = true)
    {
        $this->fosUserManager->updateUser($user, $flush);
    }

    /**
     * @param $email
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->fosUserManager->findUserByEmail($email);
    }

    /**
     * @param $username
     * @return User
     */
    public function findByUsername($username)
    {
        return $this->fosUserManager->findUserByUsername($username);
    }

    /**
     * @param $usernameOrEmail
     * @return User
     */
    public function findByUsernameOrEmail($usernameOrEmail)
    {

        return $this->fosUserManager->findUserByUsernameOrEmail($usernameOrEmail);
    }
}
