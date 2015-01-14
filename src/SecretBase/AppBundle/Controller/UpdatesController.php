<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class UpdatesController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function persistUpdatesAction(Request $request)
    {
        $images = $request->files->get("images");
        $text = $request->request->get("text");
        $user = $this->getSecurityTokenStorage()->getToken()->getUser();

        $response = $this->getUpdatesFacade()->persistUpdates($text, $user, $images);

        return new JsonResponse($response);
    }


}
