<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Entity\Media;

class MediaManager extends BaseMediaManager
{
    /**
     * @param $file
     * @param $album
     * @param string $context
     * @return null|Media
     */
    public function save($file, $album, $context = self::THUMBNAIL_CONTEXT_IMAGE)
    {
        if (empty($file) || empty($album)) {
            return null;
        }

        $media = new Media();
        $media->setBinaryContent($file);
        $media->setAlbum($album);
        $media->setContext($context);

        $this->persist($media);

        return $media;
    }

    /**
     * @param array $files
     * @param $album
     * @param string $context
     * @return array
     */
    public function msave(array $files, $album, $context = self::THUMBNAIL_CONTEXT_IMAGE)
    {
        if (empty($files) || empty($album)) {
            return array();
        }

        $medias = array();
        foreach ($files as $file) {
            if ($media = $this->save($file, $album, $context)) {
                $medias[] = $media;
            }
        }

        return $medias;
    }
}
