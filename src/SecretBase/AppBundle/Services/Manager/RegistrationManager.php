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
use SecretBase\AppBundle\Response\ErrorResponse;

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
     * @return ErrorResponse|null
     */
    public function preRegisterUser($email, $password, $role, $group)
    {
        if (empty($email)) {
            return new ErrorResponse("errors.empty.email", ErrorResponse::BAD_REQUEST);
        }

        if (empty($password)) {
            return new ErrorResponse("errors.empty.password", ErrorResponse::BAD_REQUEST);
        }

        if (empty($role)) {
            return new ErrorResponse("errors.empty.role", ErrorResponse::BAD_REQUEST);
        }

        if (!$this->isValidEmail($email)) {
            return new ErrorResponse("errors.invalidInstance.email", ErrorResponse::BAD_REQUEST);
        }

        if ($this->exists(User::getClass(), array("email" => $email))) {
            return new ErrorResponse("errors.found.email", ErrorResponse::BAD_REQUEST);
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

        return null;
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
