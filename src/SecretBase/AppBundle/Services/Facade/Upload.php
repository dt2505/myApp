<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Facade;

use SecretBase\AppBundle\Entity\Album;
use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Response\ErrorResponse;
use SecretBase\AppBundle\Response\JsonResponse;
use SecretBase\AppBundle\Services\Provider\Album\IAlbumManager;
use SecretBase\AppBundle\Services\Provider\Photo\IPhotoManager;

class Upload
{
    /** @var IAlbumManager */
    private $albumManager;
    /** @var IPhotoManager */
    private $photoManager;
    /** @var Album */
    private $album;

    public function __construct($albumManager, $photoManager)
    {
        $this->albumManager = $albumManager;
        $this->photoManager = $photoManager;
    }

    /**
     * @param $files
     * @param $owner
     * @return ErrorResponse|JsonResponse
     */
    public function uploadPhotos($files, $owner)
    {
        if (empty($files)) {
            return new JsonResponse();
        }

        try {
            $album = $this->album ? $this->album : $this->albumManager->createDefaultAlbum($owner);
            $this->photoManager->persistAll($files, $owner, $album);
        } catch (\Exception $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        return new JsonResponse();
    }

    /**
     * @param $photoId
     * @param $owner
     * @param $flush
     * @return Media|ErrorResponse
     */
    public function deletePhoto($photoId, $owner, $flush = true)
    {
        if (empty($photoId) || empty($owner)) {
            return new JsonResponse();
        }

        if (!$owner instanceof User) {
            return new ErrorResponse("errors.invalidInstance.user", ErrorResponse::BAD_REQUEST);
        }

        $photo = $this->photoManager->find($photoId);
        if ($photo) {
            return new ErrorResponse("errors.notFound.photoId", ErrorResponse::BAD_REQUEST);
        }

        if (!$photo->getOwner()->equal($owner)) {
            return new ErrorResponse("errors.denny.delete.photo", ErrorResponse::BAD_REQUEST);
        }

        try {
            return $this->photoManager->delete($photo, $flush);
        } catch (\Exception $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param $owner
     * @param $flush
     * @return Array
     */
    public function deleteAllPhotos($owner, $flush = true)
    {
        if (!$owner instanceof User) {
            return new ErrorResponse("errors.invalidInstance.user", ErrorResponse::BAD_REQUEST);
        }

        return $this->photoManager->deletePhotos($owner, null, $flush);
    }

    /**
     * @param $albumId
     * @param null $owner
     * @param bool $flush
     * @return Array
     */
    public function deletePhotos($albumId, $owner, $flush = true)
    {
        if (!$owner instanceof User) {
            return new ErrorResponse("errors.invalidInstance.user", ErrorResponse::BAD_REQUEST);
        }

        if (empty($albumId)) {
            return $this->deleteAllPhotos($owner, $flush);
        }

        $album = $this->albumManager->find($albumId);
        if ($album) {
            return new ErrorResponse("errors.notFound.albumId", ErrorResponse::BAD_REQUEST);
        }

        return $this->photoManager->deletePhotos($album, $owner, $flush);
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
     * @return IPhotoManager
     */
    protected function getPhotoManager()
    {
        return $this->photoManager;
    }
}
 