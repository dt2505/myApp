<?php

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FOSRestController
{
    /**
     * @Rest\Get("/")
     */
    public function indexAction()
    {
        try {
            return $this->render('default/index.html.twig');
        } catch (\Exception $e) {
            return new Response($e->getMessage());
        }
    }
}
