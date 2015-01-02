<?php

namespace AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AuthenticationBundle:Default:index.html.twig', array('name' => $name));
    }
}
