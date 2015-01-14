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
    /**
     * @param $photo
     * @param $owner
     * @param null $album
     * @param bool $flush
     * @return Media
     */
    public function persist($photo, $owner, $album = null, $flush = true);

    /**
     * @param array $photos
     * @param $owner
     * @param null $album
     * @param bool $flush
     * @return array<Media>
     */
    public function persistAll(array $photos, $owner, $album = null, $flush = true);

    /**
     * @param Media $photo
     * @param User $owner
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
}
 