<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends BaseController
{
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
            case "girl":
                $param[$type] = $this->getGirl();
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

    private function getGirl()
    {
        return [];
    }
}
