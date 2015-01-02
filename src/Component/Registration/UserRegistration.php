<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Component\Registration;

use Component\Entity\User;
use Component\Response\JsonResponse;

class UserRegistration extends Registration
{
    public function register($username, $password, $type)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setType($type);

        try {
            $em = $this->getEntityManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse();
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), JsonResponse::INTERNAL_SERVER_ERROR);
        }
    }
}
