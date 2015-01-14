<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use SecretBase\AppBundle\Response\ErrorResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     *
     * * @Rest\Post()
     */
    public function uploadPhotosAction(Request $request)
    {
        $images = $request->files->get("images");
        $user = $this->getSecurityTokenStorage()->getToken()->getUser();

        $response = $this->getUploadFacade()->uploadPhotos($images, $user);

        return new Response((string)$response);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deletePhotosAction(Request $request)
    {
        $albumId = $request->request->get("albumId");
        $user = $this->getSecurityTokenStorage()->getToken()->getUser();

        $response = $this->getUploadFacade()->deletePhotos($albumId, $user);
        if ($response instanceof ErrorResponse) {
            return new Response((string)$response);
        } else {
            return new Response("DONE!");
        }
    }
}
