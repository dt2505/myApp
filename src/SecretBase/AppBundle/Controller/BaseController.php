<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use SecretBase\AppBundle\Services\Util\Mailer;
use SecretBase\AppBundle\Services\Manager\MediaManager;
use SecretBase\AppBundle\Services\Manager\AlbumManager;
use SecretBase\AppBundle\Services\Manager\GroupManager;
use SecretBase\AppBundle\Services\UserRegistrationHandler;
use SecretBase\AppBundle\Services\StatusHandler;
use SecretBase\AppBundle\Services\UserProfileHandler;
use SecretBase\AppBundle\Services\FollowingHandler;

class BaseController extends FOSRestController
{
    /**
     * @return TokenStorage
     */
    protected function getSecurityTokenStorage()
    {
        return $this->get('security.token_storage');
    }

    /**
     * @return FollowingHandler
     */
    protected function getFollowingHandler()
    {
        return $this->get("following_handler");
    }

    /**
     * @return Mailer
     */
    protected function getMailHandler()
    {
        return $this->get("mailer_handler");
    }

    /**
     * @return UserProfileHandler
     */
    protected function getUserProfileHandler()
    {
        return $this->get("user_profile_handler");
    }

    /**
     * @return StatusHandler
     */
    protected function getStatusHandler()
    {
        return $this->get("status_handler");
    }
    /**
     * @return AlbumManager
     */
    protected function getAlbumManager()
    {
        return $this->get("album_manager");
    }

    /**
     * @return MediaManager
     */
    protected function getMediaManager()
    {
        return $this->get("media_manager");
    }

    /**
     * @return GroupManager
     */
    protected function getGroupManager()
    {
        return $this->get('group_manager');
    }

    /**
     * @return UserRegistrationHandler
     */
    protected function getUserRegistrationHandler()
    {
        return $this->get('user_registration_handler');
    }
}
 