<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\SonataMedia\Entity;

use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Services\Photo\IPhotoManager;
use Sonata\MediaBundle\Provider\ImageProvider;

class PhotoManager extends BaseMediaManager implements IPhotoManager
{
    private $context;

    public function __construct($mediaManager, $pool, $imageProviderName, $context)
    {
        parent::__construct($mediaManager, $pool, $imageProviderName);
        $this->context = $context;
    }

    public function persist($photo, $owner, $album = null, $flush = true)
    {
        $media = new Media();
        $media->setBinaryContent($photo);
        $media->setAlbum($album);
        $media->setContext($this->context);
        $media->setProviderName($this->getMediaProviderName());
        $media->setOwner($owner);
        $this->getMediaManager()->save($media);
    }

    public function persistAll(array $photos, $owner, $album = null, $flush = true)
    {
        foreach ($photos as $photo) {
            $this->persist($photo, $owner, $album, $flush);
        }
    }

    public function delete($photoId, $flush = true)
    {
        /** @var Media $photo */
        $photo = $this->getMediaManager()->find($photoId);
        if (empty($photo)) {
            return;
        }

        // have to manually remove thumbnails before doctrine actually delete entity otherwise there is no way to get
        // the media id, this is a bug in sonata media bundle. It didn't save the Id in its preRemove method in
        // BaseProvider.php
        /** @var Media $photo */
        $this->getPool()->getProvider($photo->getProviderName())->removeThumbnails($photo);
        $this->getMediaManager()->delete($photo);
    }

    public function deleteAll($flush = true)
    {
        $images = $this->getMediaManager()->findAll();
        foreach ($images as $image) {
            $this->delete($image, $flush);
        }
    }

    public function getPhotoUrl($photoId, $contextFormat)
    {
        /** @var Media $photo */
        $photo = $this->getMediaManager()->find($photoId);
        if (empty($photo)) {
            return null;
        }

        /** @var ImageProvider $provider */
        $provider = $this->getPool()->getProvider($photo->getProviderName());
        return $provider->generatePublicUrl($photo, $photo->getContext() . "_$contextFormat");
    }
}
 