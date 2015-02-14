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
     * @return Response
     *
     * @Rest\Get("/user/register")
     */
    public function registerUserAction(Request $request)
    {
        return $this->render("AppBundle::register.html.twig");
    }

    /**
     * @param Request $rquest
     * @return Response
     *
     * @Rest\Get("/user/registration/wizard/profile")
     */
    public function getWizardProfileAction(Request $rquest)
    {
        return $this->render("AppBundle:layout:registration/wizard/profile.html.twig");
    }

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

        try {
            $user = $this->getUserRegistrationHandler()->preRegisterUser($email, $password, $role);
            $view = $this->view(null, Response::HTTP_OK);
        } catch (\InvalidArgumentException $e) {
            $view = $this->view(array("error" => $e->getMessage()), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            $view = $this->view(array("error" => $e->getMessage()), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $view->setTemplate(":default:index.html.twig");
        return $this->handleView($view);
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

    /**
     * @param Request $request
     * @param $name
     * @return JsonResponse
     * @Rest\Get("/mails/{name}/send")
     */
    public function sendMailAction(Request $request, $name)
    {
        $mailer = $this->getMailHandler();
        $message = $mailer->createMessage(
            'Hello Email',
            'jerryd221@gmail.com',
            'dingj836@gmail.com',
            "hello~~~"
        );
//        $message->setBody($this->renderView(
//            'HelloBundle:Hello:email.txt.twig',
//            array('name' => $name)
//        ));
        $mailer->send($message);

        return new JsonResponse("DONE");
    }
}
