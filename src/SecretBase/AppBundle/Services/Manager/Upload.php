<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Entity\Album;
use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Response\ErrorResponse;
use SecretBase\AppBundle\Response\JsonResponse;
use SecretBase\AppBundle\Services\Provider\Album\IAlbumManager;
use SecretBase\AppBundle\Services\Provider\Image\IImageManager;

class Upload
{
    /** @var IAlbumManager */
    private $albumManager;
    /** @var IImageManager */
    private $imageManager;
    /** @var Album */
    private $album;

    public function __construct($albumManager, $imageManager)
    {
        $this->albumManager = $albumManager;
        $this->imageManager = $imageManager;
    }

    /**
     * @param $image
     * @param $owner
     * @param $context
     * @return Media|ErrorResponse|null
     */
    public function uploadImage($image, $owner, $context = IImageManager::THUMBNAIL_CONTEXT_IMAGE)
    {
        try {
            $album = $this->album ? $this->album : $this->albumManager->createDefaultAlbum($owner);
            return $this->imageManager->persist($image, $owner, $album, $context);
        } catch (\Exception $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $images
     * @param $owner
     * @param $context
     * @return array|ErrorResponse
     */
    public function uploadImages($images, $owner, $context = IImageManager::THUMBNAIL_CONTEXT_IMAGE)
    {
        if (empty($images)) {
            return array();
        }

        $uploadedImages = array();
        foreach ($images as $image) {
            $response = $this->uploadImage($image, $owner, $context);
            if ($response instanceof ErrorResponse) {
                return $response;
            }
            $uploadedImages[] = $response;
        }

        return $uploadedImages;
    }

    /**
     * @param $imageId
     * @param $owner
     * @param $flush
     * @return Media|ErrorResponse
     */
    public function deleteImage($imageId, $owner, $flush = true)
    {
        if (empty($imageId) || empty($owner)) {
            return new JsonResponse();
        }

        $image = $this->imageManager->find($imageId);
        if ($image) {
            return new ErrorResponse("errors.notFound.imageId", ErrorResponse::BAD_REQUEST);
        }

        if (!$image->getOwner()->equal($owner)) {
            return new ErrorResponse("errors.denny.delete.image", ErrorResponse::BAD_REQUEST);
        }

        return $this->imageManager->delete($image, $flush);
    }

    /**
     * @param $albumId
     * @param null $owner
     * @param bool $flush
     * @return Array
     */
    public function deleteImages($owner, $albumId, $flush = true)
    {
        $album = null;
        if (!empty($albumId)) {
            $album = $this->albumManager->find($albumId);
            if ($album) {
                return new ErrorResponse("errors.notFound.albumId", ErrorResponse::BAD_REQUEST);
            }
        }

        return $this->imageManager->deleteImages($owner, $album, $flush);
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @return IAlbumManager
     */
    protected function getAlbumManager()
    {
        return $this->albumManager;
    }

    /**
     * @return IImageManager
     */
    protected function getImageManager()
    {
        return $this->imageManager;
    }
}
 