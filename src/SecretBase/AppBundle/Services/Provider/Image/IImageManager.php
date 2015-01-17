<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Provider\Image;

use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Response\ErrorResponse;
use SecretBase\AppBundle\Services\Provider\IEntityManager;

interface IImageManager extends IEntityManager
{
    const THUMBNAIL_CONTEXT_IMAGE = "image";

    /**
     * @param $image
     * @param $owner
     * @param $album
     * @param bool $flush
     * @return Media
     */
    public function persist($image, $owner, $album, $flush = true);

    /**
     * @param Media $image
     * @param bool $flush
     * @return Media
     */
    public function delete($image, $flush = true);

    /**
     * @param null $owner
     * @param null $inAlbum
     * @param bool $flush
     * @return ErrorResponse|Array
     */
    public function deleteImages($owner, $inAlbum = null, $flush = true);

    /**
     * @param Media $photo
     * @param null $attachToDomain
     * @return array
     */
    public function getImageUrls(Media $photo, $attachToDomain = null);
}
 