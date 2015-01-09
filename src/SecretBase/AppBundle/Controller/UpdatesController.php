<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use Sonata\MediaBundle\Entity\MediaManager;
use Sonata\MediaBundle\Provider\ImageProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

use SecretBase\AppBundle\Entity\Media;

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
        /** @var MediaManager $mediaManager */
        $mediaManager = $this->get("sonata.media.manager.media");

        foreach ($request->files->get("images") as $image) {
            $media = new Media();
            $media->setBinaryContent($image);
            $media->setContext("user");
            $media->setProviderName("sonata.media.provider.image");
            $mediaManager->save($media);
        }

        return new JsonResponse("TODO: persist updates");
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImagesAction(Request $request)
    {
        /** @var MediaManager $mediaManager */
        $mediaManager = $this->get("sonata.media.manager.media");
        $pool = $this->get('sonata.media.pool');
        $medias = $mediaManager->findAll();

        foreach($medias as $image) {
            // remove thumbnails before doctrine actually delete entity otherwise there is no way to get the media id,
            // this is a bug in sonata media bundle. It didn't save the Id in its preRemove method in BaseProvider.php
            $pool->getProvider($image->getProviderName())->removeThumbnails($image);
            $mediaManager->delete($image);
        }

        return new JsonResponse("Done!");
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function getImageUrlAction(Request $request, $id)
    {
        /** @var MediaManager $mediaManager */
        $mediaManager = $this->get("sonata.media.manager.media");
        /** @var Media $image */
        $image = $mediaManager->find($id);
        /** @var ImageProvider $povider */
        $povider = $this->get('sonata.media.pool')->getProvider($image->getProviderName());

        $path = array(
            "general.url" => $povider->generatePath($image),
            "public.url" => $povider->generatePublicUrl($image, 'reference'),
            "private.url" => $povider->generatePrivateUrl($image, 'user_small')
        );

        return new JsonResponse($path);
    }
}
