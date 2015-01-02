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
     * @Rest\Get
     */
    public function authenticateUserAction(Request $request)
    {
        $username = $request->query->get("username");
        $password = $request->query->get("password");
        $type = $request->query->get("type");

        return new Response($this->get("authentication")->verify($username, $password, $type));
    }
}
