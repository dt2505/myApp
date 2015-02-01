<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Entity\Album;

class AlbumManager extends ORManager
{
    const DEFAULT_ALBUM = "album.name.default";

    /** @var MediaManager */
    private $mediaManager;

    public function __construct($em, $mediaManager)
    {
        parent::__construct($em, Album::getClass());
        $this->mediaManager = $mediaManager;
    }

    /**
     * @param null $owner
     * @return Album
     */
    public function createDefaultAlbum($owner = null)
    {
        $album = $this->create(self::DEFAULT_ALBUM, $owner);
        $album->setDefault(true);

        return $album;
    }

    /**
     * @param $name
     * @param null $owner
     * @return Album
     */
    public function create($name, $owner = null)
    {
        return new Album($name, $owner);
    }

    /**
     * {@inheritdoc}
     */
    public function persist($album, $flush = true)
    {
        if ($album->isDefault() && ($defaultAlbum = $this->findDefaultAlbum($album->getOwner()))) {
            $defaultAlbum->setDefault(false);
            $this->flush($defaultAlbum);
        }

        parent::persist($album, $flush);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($album, $flush = true)
    {
        if ($medias = $album->getMedias()) {
            $this->mediaManager->mremove($medias, $flush);
        }

        parent::remove($album, $flush);
    }

    /**
     * @param $owner
     * @return Album
     */
    public function findDefaultAlbum($owner)
    {
        return $this->findOneBy(array("owner" => $owner, "default" => true));
    }
}
