<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function changeAvatarAction(Request $request)
    {
        $avatar = $request->request->get("avatar");
        $user = $this->getSecurityTokenStorage()->getToken()->getUser();

        try {
            $this->getUserProfileHandler()->updateAvatar($user, $avatar);
            return new Response("DONE");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function changeCoverAction(Request $request)
    {
        $cover = $request->request->get("cover");
        $user = $this->getSecurityTokenStorage()->getToken()->getUser();

        try {
            $this->getUserProfileHandler()->updateAvatar($user, $cover);
            return new Response("DONE");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function updateProfileAction(Request $request)
    {
        return new JsonResponse(array("message" => "for updating user's profile details", "code" => 200));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function resetPasswordAction(Request $request)
    {
        return new JsonResponse(array("message" => "for resetting user's password", "code" => 200));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function changePasswordAction(Request $request)
    {
        return new JsonResponse(array("message" => "for changing user's password", "code" => 200));
    }
}
