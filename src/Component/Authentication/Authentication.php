<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Component\Authentication;

use Doctrine\ORM\EntityManager;

use Component\Entity\User;
use Component\Response\JsonResponse;

class Authentication
{
    private $entityManager;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $token
     * @return JsonResponse
     */
    public function verify($username, $password, $token)
    {
        if (empty($username) || empty($password)) {
            return new JsonResponse("Insufficient argument", JsonResponse::BAD_REQUEST);
        }

        try {
            $userRepo = $this->entityManager->getRepository(User::getClassName());
            if (empty($userRepo)) {
                return new JsonResponse("Invalid entity supplied.", JsonResponse::BAD_REQUEST);
            }

            $found = $userRepo->findOneBy(array("username" => $username));
            if (!$found || password_verify($password, $found->getPassword())) {
                return new JsonResponse("Invalid username or password.", JsonResponse::BAD_REQUEST);
            }

            return new JsonResponse("verified", JsonResponse::OK, array(), array("token" => $token));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), JsonResponse::INTERNAL_SERVER_ERROR);
        }
    }
}
