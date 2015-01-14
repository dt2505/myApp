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

use SecretBase\AppBundle\Services\Provider\IEntityManager;

abstract class BaseMediaManager implements IEntityManager
{
    /** @var MediaManager $mediaManager */
    private $mediaManager;
    /** @var Pool $pool */
    private $pool;

    function __construct(MediaManager $mediaManager, Pool $pool)
    {
        $this->mediaManager = $mediaManager;
        $this->pool = $pool;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getMediaManager()->findAll();
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
        return $this->getMediaManager()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getMediaManager()->findOneBy($criteria, $orderBy);
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->getMediaManager()->find($id);
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
 