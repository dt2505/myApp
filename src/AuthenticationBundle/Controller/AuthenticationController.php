<?php

namespace AuthenticationBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends FOSRestController
{
    /**
     * @param Request $request
     * @return Response
     * @Rest\Post()
     */
    public function authenticateUserAction(Request $request)
    {
        $username = $request->request->get("username");
        $password = $request->request->get("password");
        $token = $request->request->get("token");

        return new Response($this->get("authentication")->verify($username, $password, $token));
    }
}
