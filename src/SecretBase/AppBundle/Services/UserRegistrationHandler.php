<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services;

use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Services\Manager\GroupManager;
use SecretBase\AppBundle\Services\Manager\UserManager;

class UserRegistrationHandler
{
    /** @var UserManager */
    private $userManager;
    /** @var GroupManager */
    private $groupManager;

    public function __construct($userManager, $groupManager)
    {
        $this->userManager = $userManager;
        $this->groupManager = $groupManager;
    }

    /**
     * @param $email
     * @param $password
     * @param $role
     * @return User
     * @throws \InvalidArgumentException
     */
    public function preRegisterUser($email, $password, $role)
    {
        if (empty($email)) {
            throw new \InvalidArgumentException("errors.empty.email");
        }

        if (empty($password)) {
            throw new \InvalidArgumentException("errors.empty.password");
        }

        if (empty($role)) {
            throw new \InvalidArgumentException("errors.empty.role");
        }

        if (!$this->isValidEmail($email)) {
            throw new \InvalidArgumentException("errors.invalid.email");
        }

        if ($this->userManager->exists(array("email" => $email))) {
            throw new \InvalidArgumentException("errors.found.email");
        }

        // by default all users are in free group
        $freeGroup = $this->groupManager->findFreeGroup();
        if (!$freeGroup) {
            $freeGroup = $this->groupManager->createFreeGroup(true);
        }

        /** @var User $user */
        $user = $this->userManager->create();
        $user->setEmail($email);
        $user->setUsername($email);
        $user->setPlainPassword($password);
        $user->setEnabled(false);
        $user->addRole($role);
        $user->addGroup($freeGroup);
        $this->userManager->persist($user);

        return $user;
    }

    /**
     * @param $email
     * @param bool $checkMX
     * @param bool $checkHost
     * @return bool
     */
    private function isValidEmail($email, $checkMX = true, $checkHost = false)
    {
        if ($valid = preg_match('/.+\@.+\..+/', $email)) {
            $host = substr($email, strpos($email, '@') + 1);
            if ($checkMX) {
                $valid = $valid && checkdnsrr($host, 'MX');
            }

            if ($checkHost) {
                $valid = $valid && (checkdnsrr($host) || (checkdnsrr($host, "A") || checkdnsrr($host, "AAAA")));
            }

            return $valid;
        }

        return false;
    }
}
