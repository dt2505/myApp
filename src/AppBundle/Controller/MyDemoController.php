<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 13/12/14
 * Time: 2:44 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MyDemoController extends Controller
{
    public function getWordsAction(Request $request)
    {
        return new Response("a ha, you saw me.");
    }
}