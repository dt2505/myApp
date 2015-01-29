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

class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post("/user/pre-register")
     */
    public function preRegisterUserAction(Request $request)
    {
        $email = $request->request->get("email");
        $password = $request->request->get("password");
        $role = $request->request->get("role");
        $freeGroup = $this->getGroupManager()->createFreeGroup(true);

        $errorResponse = $this->getRegistrationManager()->preRegisterUser($email, $password, $role, $freeGroup);
        if ($errorResponse) {
            return new Response((string)$errorResponse);
        }

        return new Response('Done');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Rest\Post("/registration/steps/two")
     */
    public function registerUserStepTwoAction(Request $request)
    {
        return new JsonResponse(array("message" => "registration wizard step two", "code" => 200));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post("/registration/steps/final")
     */
    public function registerUserFinalAction(Request $request)
    {
        return new JsonResponse(array("message" => "for user registration", "code" => 200));
    }

    public function sendMailAction(Request $request, $name)
    {
        $mailer = $this->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject('Hello Email')
            ->setFrom('jerryd221@gmail.com')
            ->setTo('dingj836@gmail.com')
            ->setBody($this->renderView(
                'HelloBundle:Hello:email.txt.twig',
                array('name' => $name)
            ))
        ;
        $mailer->send($message);

        return new JsonResponse("DONE");
    }
}
