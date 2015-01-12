<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\SonataMedia\Entity;

use Sonata\CoreBundle\Model\BaseEntityManager;

use SecretBase\AppBundle\Services\Album\IAlbumManager;
use SecretBase\AppBundle\Services\Photo\IPhotoManager;
use SecretBase\AppBundle\Entity\Album;

class AlbumManager extends BaseEntityManager implements IAlbumManager
{
    private $photoManager;
    private $currentAlbum;

    public function __construct($class, $registry, IPhotoManager $photoManager)
    {
        parent::__construct($class, $registry);
        $this->photoManager = $photoManager;
    }

    public function create($name = null) {
        $this->currentAlbum = null;

        if ($name) {
            $this->currentAlbum = new $this->class($name);
        } else {
            // create album with default name
            $this->currentAlbum =  parent::create();
        }

        return $this->currentAlbum;
    }

    public function delete($album, $flush = true)
    {
        if ($medias = $album->getMedias()) {
            foreach ($medias as $media) {
                $this->photoManager->delete($media, $flush);
            }
        }

        parent::delete($album, $flush);
    }

    public function getCurrentAlbum()
    {
        return $this->currentAlbum;
    }

    public function persist($album, $owner, $flush = true)
    {
        /** @var Album $album */
        $album->setOwner($owner);
        parent::save($album, $flush);
    }
}
 