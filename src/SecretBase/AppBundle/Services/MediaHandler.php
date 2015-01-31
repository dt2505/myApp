<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services;

use SecretBase\AppBundle\Services\Manager\AlbumManager;
use SecretBase\AppBundle\Services\Manager\MediaManager;

abstract class MediaHandler
{
    /** @var MediaManager */
    private $mediaManager;
    /** @var AlbumManager */
    private $albumManager;

    public function __construct($mediaManager, $albumManager)
    {
        $this->mediaManager = $mediaManager;
        $this->albumManager = $albumManager;
    }

    /**
     * @param $user
     * @return \SecretBase\AppBundle\Entity\Album
     */
    protected function findDefaultAlbum($user)
    {
        // create a default album if user does not have one
        $defaultAlbum = $this->albumManager->findDefaultAlbum($user);
        if (!$defaultAlbum) {
            $defaultAlbum = $this->albumManager->createDefaultAlbum($user);
        }

        return $defaultAlbum;
    }

    /**
     * @return MediaManager
     */
    protected function getMediaManager()
    {
        return $this->mediaManager;
    }

    /**
     * @return AlbumManager
     */
    protected function getAlbumManager()
    {
        return $this->albumManager;
    }
}
