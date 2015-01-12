<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\SonataMedia\Entity;

use Sonata\MediaBundle\Entity\MediaManager;
use Sonata\MediaBundle\Provider\Pool;

abstract class BaseMediaManager
{
    /** @var string */
    private $mediaProviderName;
    /** @var MediaManager $mediaManager */
    private $mediaManager;
    /** @var Pool $pool */
    private $pool;

    function __construct(MediaManager $mediaManager, Pool $pool, $imageProviderName)
    {
        $this->mediaProviderName = $imageProviderName;
        $this->mediaManager = $mediaManager;
        $this->pool = $pool;
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
     * @return MediaManager
     */
    public function getMediaManager()
    {
        return $this->mediaManager;
    }

    /**
     * @param MediaManager $mediaManager
     */
    public function setMediaManager($mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    /**
     * @return Pool
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * @param Pool $pool
     */
    public function setPool($pool)
    {
        $this->pool = $pool;
    }
}
 