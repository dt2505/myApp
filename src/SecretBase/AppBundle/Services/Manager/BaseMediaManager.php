<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use Sonata\MediaBundle\Entity\MediaManager;
use Sonata\MediaBundle\Provider\Pool;

use SecretBase\AppBundle\Entity\Media;

abstract class BaseMediaManager extends ORMManager
{
    const THUMBNAIL_CONTEXT_IMAGE = "image";

    /** @var MediaManager $sonataMediaManager */
    private $sonataMediaManager;
    /** @var Pool $pool */
    private $pool;

    function __construct($em, MediaManager $sonataMediaManager, Pool $pool)
    {
        parent::__construct($em, Media::getClass());
        $this->sonataMediaManager = $sonataMediaManager;
        $this->pool = $pool;
    }

    /**
     * @param Media $media
     * @param bool $flush
     */
    public function persist(Media $media, $flush = true)
    {
        $this->sonataMediaManager->save($media, $flush);
    }

    /**
     * @param array<Media> $medias
     * @param bool $flush
     */
    public function mpersist(array $medias, $flush = true)
    {
        if (empty($medias)) {
            return;
        }

        foreach ($medias as $media) {
            $this->persist($media, $flush);
        }
    }

    /**
     * @param Media $media
     * @param bool $flush
     * @return Media
     */
    public function remove(Media $media, $flush = true)
    {
        $copy = clone $media;
        $this->sonataMediaManager->delete($media, $flush);
        // have to manually remove thumbnails before doctrine actually delete entity otherwise there is no way to get
        // the media id, this is a bug in sonata media bundle. It didn't save the Id in its preRemove method in
        // BaseProvider.php
        $this->pool->getProvider($copy->getProviderName())->removeThumbnails($copy);
    }

    /**
     * @param array<Media> $medias
     * @param bool $flush
     */
    public function mremove(array $medias, $flush = true)
    {
        if (empty($medias)) {
            return;
        }

        foreach ($medias as $media) {
            $this->remove($media, $flush);
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->sonataMediaManager->findAll();
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->sonataMediaManager->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->sonataMediaManager->findOneBy($criteria, $orderBy);
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->sonataMediaManager->find($id);
    }

    /**
     * @return Media
     */
    public function create()
    {
        return $this->sonataMediaManager->create();
    }

    /**
     * @param Media|int $media
     * @param $format
     * @param string $domain
     * @return null|string
     */
    public function getMediaUrl($media, $format, $domain = null)
    {
        if ($media instanceof Media) {
            $mediaEntity = $media;
        } else {
            $mediaEntity = $this->find($media);
        }

        return $this->generateMediaUrl($mediaEntity, $format, $domain);
    }

    /**
     * @param Media|int $media
     * @param string $domain
     * @return array
     */
    public function getMediaUrls($media, $domain = null)
    {
        if ($media instanceof Media) {
            $mediaEntity = $media;
        } else {
            $mediaEntity = $this->find($media);
        }

        if (!$mediaEntity) {
            return array();
        }

        $formats = $this->getContextFormats($mediaEntity->getContext());
        if (empty($formats)) {
            return array();
        }

        $urls = array();
        foreach ($formats as $key => $format) {
            $urls[$key] = $this->generateMediaUrl($mediaEntity, $key, $domain);
        }

        return $urls;
    }

    /**
     * @param $media
     * @param $format
     * @param string $domain
     * @return null|string
     */
    private function generateMediaUrl($media, $format, $domain = null)
    {
        if (!$media instanceof Media) {
            return null;
        }

        $provider = $this->pool->getProvider($media->getProviderName());
        $url = $provider->generatePublicUrl($media, $media->getContext() . "_$format");

        if ($domain) {
            return sprintf("%s/%s", rtrim($domain, "/"), ltrim($url, "/"));
        } else {
            return $url;
        }
    }

    /**
     * @param $context
     * @return array
     */
    private function getContextFormats($context)
    {
        $context = $this->pool->getContext($context);
        return array_key_exists("formats", $context) ? $context["formats"] : array();
    }
}
