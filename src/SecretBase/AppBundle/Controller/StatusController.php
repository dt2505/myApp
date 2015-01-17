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

        $response = $this->getStatusFacade()->persistStatus($text, $user, $images);

        return new Response((string)$response);
    }


}
