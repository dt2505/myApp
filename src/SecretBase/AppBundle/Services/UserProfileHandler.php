<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services;

use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Services\Manager\UserManager;

class UserProfileHandler extends MediaHandler
{
    /** @var UserManager */
    private $userManager;

    public function __construct($mediaManager, $albumManager, $userManager)
    {
        parent::__construct($mediaManager, $albumManager);
        $this->userManager = $userManager;
    }

    /**
     * @param User $user
     * @param $avatar
     */
    public function updateAvatar(User $user, $avatar)
    {
        if (!$avatar) {
            return;
        }

        // remove the existed avatar
        if ($currentAvatar = $user->getAvatar()) {
            $this->getMediaManager()->remove($currentAvatar);
        }

        // create a default album if user does not have one
        $defaultAlbum = parent::findDefaultAlbum($user);

        // save new avatar
        $media = $this->getMediaManager()->save($avatar, $defaultAlbum);
        $user->setAvatar($media);
        $this->userManager->flush($user);
    }

    /**
     * @param User $user
     * @param $cover
     */
    public function updateCover(User $user, $cover)
    {
        if (!$cover) {
            return;
        }

        // remove the existed cover
        if ($currentCover = $user->getCover()) {
            $this->getMediaManager()->remove($currentCover);
        }

        // create a default album if user does not have one
        $defaultAlbum = parent::findDefaultAlbum($user);

        // save new cover
        $media = $this->getMediaManager()->save($cover, $defaultAlbum);
        $user->setCover($media);
        $this->userManager->flush($user);
    }
}
