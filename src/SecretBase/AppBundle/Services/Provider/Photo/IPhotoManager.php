<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\Photo;

use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Response\ErrorResponse;
use SecretBase\AppBundle\Services\Provider\IEntityManager;

interface IPhotoManager extends IEntityManager
{
    const THUMBNAIL_CONTEXT_PHOTO = "photo";

    /**
     * @param $photo
     * @param $owner
     * @param $album
     * @param bool $flush
     * @return Media
     */
    public function persist($photo, $owner, $album, $flush = true);

    /**
     * @param Media $photo
     * @param bool $flush
     * @return Media
     */
    public function delete($photo, $flush = true);

    /**
     * @param null $owner
     * @param null $inAlbum
     * @param bool $flush
     * @return ErrorResponse|Array
     */
    public function deletePhotos($owner, $inAlbum = null, $flush = true);

    /**
     * @param Media $photo
     * @param null $attachToDomain
     * @return array
     */
    public function getPhotoUrls(Media $photo, $attachToDomain = null);
}
 