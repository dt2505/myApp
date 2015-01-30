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

class RegistrationManager extends Manager
{
    /** @var UserManagerInterface */
    private $userManager;

    public function __construct($em, $userManager)
    {
        parent::__construct($em);
        $this->userManager = $userManager;
    }

    /**
     * @param $email
     * @param $password
     * @param $role
     * @param $group
     * @return User
     * @throws \InvalidArgumentException
     */
    public function preRegisterUser($email, $password, $role, $group)
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

        if ($this->exists(User::getClass(), array("email" => $email))) {
            throw new \InvalidArgumentException("errors.found.email");
        }

        /** @var User $user */
        $user = $this->userManager->createUser();
        $user->setEmail($email);
        $user->setUsername($email);
        $user->setPlainPassword($password);
        $user->setEnabled(false);
        $user->addRole($role);
        $user->addGroup($group);
        $this->userManager->updateUser($user);

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
