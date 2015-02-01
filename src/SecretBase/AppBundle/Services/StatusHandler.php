<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services;

use SecretBase\AppBundle\Entity\Media;
use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Services\Manager\StatusManager;
use SecretBase\AppBundle\Services\Util\Serializer;

class StatusHandler extends MediaHandler
{
    /** @var StatusManager */
    private $statusManager;

    function __construct($mediaManager, $albumManager, $statusManager)
    {
        parent::__construct($mediaManager, $albumManager);
        $this->statusManager = $statusManager;
    }

    /**
     * @param string $text
     * @param User $user
     * @param array $files
     */
    public function save($text, User $user, $files = array())
    {
        if (empty($text) && empty($files)) {
            return;
        }

        $medias = array();
        if (!empty($files)) {
            // create a default album if user does not have album
            $defaultAlbum = parent::findDefaultAlbum($user);
            // upload media files and persist them
            $medias = $this->getMediaManager()->msave($files, $defaultAlbum);
        }

        // save updates to noSQL storage
        $jsonData = $this->createStatusJson($text, $user, $medias);
        $this->statusManager->persist($jsonData);
    }

    /**
     * @param $text
     * @param User $user
     * @param $medias
     * @return string
     */
    private function createStatusJson($text, User $user, $medias)
    {
        $userJson = $this->createUserJson($user);
        $data = array_merge(array("user" => $userJson), array(
            "text" => $text,
            "created_at" => new \DateTime(),
            "updated_at" => new \DateTime()
        ));

        if ($mediaJson = $this->createMediaJson($medias)) {
            $data = array_merge(array("medias" => $mediaJson), $data);
        }

        return Serializer::serialize($data);
    }

    /**
     * @param User $user
     * @return array
     */
    private function createUserJson(User $user)
    {
        $userJson = array(
            "id" => $user->getId(),
            "username" => $user->getUsername(),
            "description" => $user->getDescription(),
            "created_at" => $user->getCreatedAt(),
            "updated_at" => $user->getUpdatedAt()
        );

        if($avatar = $user->getAvatar()) {
            $avatarUrls = $this->getMediaManager()->getMediaUrls($avatar);
            $userJson = array_merge(array("avatar" => $avatarUrls), $userJson);
        }

        if($cover = $user->getCover()) {
            $coverUrls = $this->getMediaManager()->getMediaUrls($cover);
            $userJson = array_merge(array("cover" => $coverUrls), $userJson);
        }

        if($roles = $user->getRoles()) {
            $userJson = array_merge(array("roles" => $roles), $userJson);
        }

        return array("user" => $userJson);
    }

    /**
     * @param array $medias
     * @return array
     */
    private function createMediaJson(array $medias)
    {
        $mediaList = array();
        if (!empty($medias)) {
            /** @var Media $media */
            foreach ($medias as $media) {
                $mediaList[] = [
                    "id" => $media->getId(),
                    "urls" => $this->getMediaManager()->getMediaUrls($media)
                ];
            }
        }

        if (empty($mediaList)) {
            return null;
        }

        return array("medias" => $mediaList);
    }
}
 