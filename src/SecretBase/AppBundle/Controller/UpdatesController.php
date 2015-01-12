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
use FOS\RestBundle\Controller\FOSRestController;

use SecretBase\AppBundle\Services\Album\IAlbumManager;
use SecretBase\AppBundle\Services\Photo\IPhotoManager;

class UpdatesController extends FOSRestController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function persistUpdatesAction(Request $request)
    {
        $owner = $this->get('security.token_storage')->getToken()->getUser();

        /** @var IAlbumManager $albumManager */
        $albumManager = $this->get("media.manager.album");
        $defaultAlbum = $albumManager->create();
        $albumManager->persist($defaultAlbum, $owner);

        /** @var IPhotoManager $photoManager */
        $photoManager = $this->get("media.manager.photo");
        $photoManager->persistAll($request->files->get("images"), $owner, $defaultAlbum);

        return new JsonResponse("TODO: persist updates");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImagesAction(Request $request)
    {
        /** @var IPhotoManager $photoManager */
        $photoManager = $this->get("media.manager.photo");
        $photoManager->deleteAll();

        return new JsonResponse("Done!");
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getImageUrlAction(Request $request, $id)
    {
        /** @var IPhotoManager $photoManager */
        $photoManager = $this->get("media.manager.photo");
        $path = array(
            "public.url" => $photoManager->getPhotoUrl($id, "small"),
        );

        return new JsonResponse($path);
    }
}
