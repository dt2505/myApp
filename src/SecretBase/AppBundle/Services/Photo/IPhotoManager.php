<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Photo;

interface IPhotoManager
{
    public function persist($photo, $owner, $album = null, $flush = true);
    public function persistAll(array $photos, $owner, $album = null, $flush = true);
    public function delete($photoId, $flush = true);
    public function deleteAll($flush = true);

    public function getPhotoUrl($photoId, $contextFormat);
}
 