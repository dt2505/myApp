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
    private $um;

    public function __construct($em, $um)
    {
        parent::__construct($em, User::getClass());
        $this->um = $um;
    }

    /**
     * @return User
     */
    public function create()
    {
        return $this->um->createUser();
    }

    /**
     * @param User $user
     * @param bool $flush
     */
    public function persist(User $user, $flush = true)
    {
        $this->um->updateUser($user, $flush);
    }
}
