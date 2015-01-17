<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\SonataMedia\Entity;

use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Services\Provider\Image\IImageManager;
use Sonata\MediaBundle\Provider\ImageProvider;

class ImageManager extends BaseMediaManager implements IImageManager
{
    /** @var string */
    private $context;
    /** @var string */
    private $mediaProviderName;

    public function __construct($mediaManager, $pool, $imageProviderName)
    {
        parent::__construct($mediaManager, $pool);
        $this->mediaProviderName = $imageProviderName;
    }

    /**
     * {@inheritdoc}
     */
    public function persist($image, $owner, $album, $context = self::THUMBNAIL_CONTEXT_IMAGE, $flush = true)
    {
        $media = new Media();
        $media->setBinaryContent($image);
        $media->setAlbum($album);
        $media->setContext($context);
        $media->setProviderName($this->getMediaProviderName());
        $media->setOwner($owner);
        $this->getMediaManager()->save($media, $flush);

        return $media;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($image, $flush = true)
    {
        if ($image == null) {
            return null;
        }
        // have to manually remove thumbnails before doctrine actually delete entity otherwise there is no way to get
        // the media id, this is a bug in sonata media bundle. It didn't save the Id in its preRemove method in
        // BaseProvider.php
        /** @var Media $image */
        $this->getPool()->getProvider($image->getProviderName())->removeThumbnails($image);
        $this->getMediaManager()->delete($image);

        return $image;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteImages($owner, $inAlbum = null, $flush = true)
    {
        $criteria = array("owner" => $owner);

        if ($inAlbum) {
            $criteria["album"] = $inAlbum;
        }

        $images = $this->getMediaManager()->findBy($criteria);
        if (empty($images)) {
            return array();
        }

        $oldImages = array();
        foreach ($images as $image) {
            if ($oldImage = $this->delete($image, $flush)) {
                $oldImages[] = $oldImage;
            }
        }

        return $oldImages;
    }

    /**
     * {@inheritdoc}
     */
    public function getImageUrl(Media $image, $contextFormat, $attachToDomain = null)
    {
        $domain = $attachToDomain ? sprintf("%s/", rtrim($attachToDomain, "/")) : null;

        /** @var ImageProvider $provider */
        $provider = $this->getPool()->getProvider($image->getProviderName());
        return $domain . $provider->generatePublicUrl($image, $image->getContext() . "_$contextFormat");
    }

    /**
     * {@inheritdoc}
     */
    public function getImageUrls(Media $photo, $attachToDomain = null)
    {
        $formats = $this->getContextFormats($photo->getContext());
        if (empty($formats)) {
            return null;
        }

        $urls = array();
        foreach ($formats as $key => $format) {
            $urls[$this->context][$key] = $this->getImageUrl($photo, $key, $attachToDomain);
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
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param string $context
     */
    public function setContext($context)
    {
        $this->context = $context;
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
 