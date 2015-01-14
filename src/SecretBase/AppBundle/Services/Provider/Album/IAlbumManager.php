<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\Album;

use SecretBase\AppBundle\Entity\Album;
use SecretBase\AppBundle\Services\Provider\IEntityManager;

interface IAlbumManager extends IEntityManager
{
    /**
     * @param null $name
     * @return Album
     */
    public function create($name = null);

    /**
     * @param $owner
     * @param bool $andPersistIt
     * @return Album
     */
    public function createDefaultAlbum($owner, $andPersistIt = true);

    /**
     * @param $album
     * @param bool $flush
     */
    public function delete($album, $flush = true);

    /**
     * @param $album
     * @param bool $flush
     */
    public function persist($album, $flush = true);

    /**
     * @return Album
     */
    public function getCurrentAlbum();

    /**
     * @return string
     */
    public function getClass();
}
 