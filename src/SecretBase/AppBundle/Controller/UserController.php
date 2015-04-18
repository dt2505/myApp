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
            $this->getUserProfileHandler()->updateCover($user, $cover);
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
     * @Rest\Get("/password/forgot")
     */
    public function forgotPasswordAction(Request $request)
    {
        return $this->render("AppBundle::forgot-password.html.twig");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post("/password/reset")
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
     * @param $type
     * @return Response
     *
     * @Rest\Get("/settings/{type}", defaults={"type" = "profile"})
     */
    public function getSettingsAction(Request $request, $type)
    {
        $param = [];

        switch($type) {
            case "profile":
                $param[$type] = $this->getProfile();
                break;
            case "account":
                $param[$type] = $this->getAccount();
                break;
            case "contact":
                $param[$type] = $this->getContact();
                break;
            case "detail":
                $param[$type] = $this->getServiceDetail();
                break;
            default:
                return new Response("Not found", Response::HTTP_NOT_FOUND);
                break;
        }
        return $this->render("AppBundle::setting.html.twig", $param);
    }

    private function getProfile()
    {
        return [];
    }

    private function getAccount()
    {
        return [];
    }

    private function getContact()
    {
        return [];
    }

    private function getServiceDetail()
    {
        return [
            "units" => [
                ["id" => 'm', "name" => "Minute", "predefined" => true, "checked" => true],
                ["id" => 'h', "name" => "Hour", "predefined" => true, "checked" => true],
                ["id" => 'd', "name" => "Day", "predefined" => true],
                ["id" => 'w', "name" => "Week", "predefined" => true],
                ["id" => 'M', "name" => "Month", "predefined" => true],
                ["id" => 'y', "name" => "Year", "predefined" => true]
            ],
            "currencies" => [
                ["id" => 1, "symbol" => "$", "shortName" =>"AUD", "fullName"=>"Australia Dollar", "predefined" => true, "checked" => true],
                ["id" => 2, "symbol" => "¥", "shortName" =>"CNY", "fullName"=>"Chinese Yuan", "predefined" => true, "checked" => true],
                ["id" => 3, "symbol" => "$", "shortName" =>"USD", "fullName"=>"American Dollar", "predefined" => true],
                ["id" => 4, "symbol" => "€", "shortName" =>"EUR", "fullName"=>"European Dollar", "predefined" => true],
            ]
        ];
    }
}
