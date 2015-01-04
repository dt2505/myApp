<?php

namespace RegistrationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends FOSRestController
{
    /**
     * @param Request $request
     * @return Response
     * @Rest\Post()
     */
    public function registerUserAction(Request $request)
    {
        $username = $request->request->get("username");
        $password = $request->request->get("password");
        $type = $request->request->get("type");

        return new Response($this->get("user_registration")->register($username, $password, $type));
    }
}
