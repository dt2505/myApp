<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\SonataMedia\Entity;

use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Response\ErrorResponse;
use SecretBase\AppBundle\Services\Provider\Photo\IPhotoManager;
use Sonata\MediaBundle\Provider\ImageProvider;

class PhotoManager extends BaseMediaManager implements IPhotoManager
{
    /** @var string */
    private $context;
    /** @var string */
    private $mediaProviderName;

    public function __construct($mediaManager, $pool, $imageProviderName, $context)
    {
        parent::__construct($mediaManager, $pool);
        $this->mediaProviderName = $imageProviderName;
        $this->context = $context;
    }

    /**
     * {@inheritdoc}
     */
    public function persist($photo, $owner, $album = null, $flush = true)
    {
        $media = new Media();
        $media->setBinaryContent($photo);
        $media->setAlbum($album);
        $media->setContext($this->context);
        $media->setProviderName($this->getMediaProviderName());
        $media->setOwner($owner);
        $this->getMediaManager()->save($media, $flush);

        return $media;
    }

    /**
     * {@inheritdoc}
     */
    public function persistAll(array $photos, $owner, $album = null, $flush = true)
    {
        $medias = array();
        foreach ($photos as $photo) {
            $medias[] = $this->persist($photo, $owner, $album, $flush);
        }
        return $medias;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($photo, $flush = true)
    {
        // have to manually remove thumbnails before doctrine actually delete entity otherwise there is no way to get
        // the media id, this is a bug in sonata media bundle. It didn't save the Id in its preRemove method in
        // BaseProvider.php
        /** @var Media $photo */
        $this->getPool()->getProvider($photo->getProviderName())->removeThumbnails($photo);
        $this->getMediaManager()->delete($photo);

        return $photo;
    }

    /**
     * {@inheritdoc}
     */
    public function deletePhotos($owner, $inAlbum = null, $flush = true)
    {
        if (!$owner instanceof User) {
            return new ErrorResponse("errors.invalidInstance.user", ErrorResponse::BAD_REQUEST);
        }

        $criteria = array("owner" => $owner);

        if ($inAlbum) {
            $criteria["album"] = $inAlbum;
        }

        $images = $this->getMediaManager()->findBy($criteria);
        if (empty($images)) {
            return array();
        }

        $oldPhotos = array();
        foreach ($images as $image) {
            if ($oldPhoto = $this->delete($image, $flush)) {
                $oldPhotos[] = $oldPhoto;
            }
        }

        return $oldPhotos;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhotoUrl(Media $photo, $contextFormat, $attachToDomain = null)
    {
        $domain = $attachToDomain ? sprintf("%s/", rtrim($attachToDomain, "/")) : null;

        /** @var ImageProvider $provider */
        $provider = $this->getPool()->getProvider($photo->getProviderName());
        return $domain . $provider->generatePublicUrl($photo, $photo->getContext() . "_$contextFormat");
    }

    /**
     * {@inheritdoc}
     */
    public function getPhotoUrls(Media $photo, $attachToDomain = null)
    {
        $formats = $this->getContextFormats($photo->getContext());
        if (empty($formats)) {
            return null;
        }

        $urls = array();
        foreach ($formats as $key => $format) {
            $urls[$this->context][$key] = $this->getPhotoUrl($photo, $key, $attachToDomain);
        }

        return $urls;
    }

    /**
     * @return string
     */
    public function getMediaProviderName()
    {
        return $this->mediaProviderName;
    }

    /**
     * @param string $mediaProviderName
     */
    public function setMediaProviderName($mediaProviderName)
    {
        $this->mediaProviderName = $mediaProviderName;
    }

    /**
     * @param $contextName
     * @return array
     */
    private function getContextFormats($contextName)
    {
        $context = $this->getPool()->getContext($contextName);
        return array_key_exists("formats", $context) ? $context["formats"] : array();
    }
}
 