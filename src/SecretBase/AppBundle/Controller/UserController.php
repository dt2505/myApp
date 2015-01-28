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

class UserController extends ImageController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function uploadAvatarAction(Request $request)
    {
        return new JsonResponse(array("message" => "for uploading user's avatar", "code" => 200));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function uploadCoverAction(Request $request)
    {
        return new JsonResponse(array("message" => "for uploading user's cover", "code" => 200));
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

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function followUserAction(Request $request)
    {
        return new JsonResponse(array("message" => "for user to follow someone else", "code" => 200));
    }
}
