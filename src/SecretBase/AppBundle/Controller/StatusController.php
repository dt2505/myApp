<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class StatusController extends BaseController
{
    public function getLobbyAction(Request $request)
    {
        return $this->render("AppBundle::lobby.html.twig");
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Rest\Post()
     */
    public function persistStatusAction(Request $request)
    {
        $images = $request->files->get("images");
        $text = $request->request->get("text");
        $user = $this->getSecurityTokenStorage()->getToken()->getUser();

        try {
            $this->getStatusHandler()->save($text, $user, $images);
            return new Response("DONE");
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
