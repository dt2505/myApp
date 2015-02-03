<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services;

use SecretBase\AppBundle\Entity\User;
use SecretBase\AppBundle\Services\Manager\FollowingManager;
use SecretBase\AppBundle\Services\Manager\UserManager;

class FollowingHandler
{
    /** @var FollowingManager */
    private $followingManager;
    /** @var UserManager */
    private $userManager;

    public function __construct($followingManager, $userManager)
    {
        $this->followingManager = $followingManager;
        $this->userManager = $userManager;
    }

    /**
     * @param User $me
     * @param $someone
     */
    public function followUser(User $me, $someone)
    {
        $user = $this->cast($someone);
        if (!$this->followingManager->exists(array("user" => $me, "following" => $user))) {
            $following = $this->followingManager->create();
            $following->setUser($me);
            $following->setFollowing($user);
            $this->followingManager->persist($following);
        }
    }

    /**
     * @param User $me
     * @param $someone
     */
    public function unfollowUser(User $me, $someone)
    {
        if ($user = $this->cast($someone)) {
            $this->followingManager->removeBy(array("user" => $me, "following" => $user));
        }
    }

    /**
     * @param User $me
     * @param $someone
     * @return bool
     */
    public function followed(User $me, $someone)
    {
        if ($user = $this->cast($someone)) {
            return $this->followingManager->exists(array("user" => $me, "following" => $user));
        }
    }

    /**
     * @param User $me
     * @return array<User>
     */
    public function getFollowers(User $me)
    {
        return $this->followingManager->getFollowers($me);
    }

    /**
     * @param User $me
     * @return array<User>
     */
    public function getFollowings(User $me)
    {
        return $this->followingManager->getFollowings($me);
    }

    /**
     * @param mixed $user
     * @return User
     */
    private function cast($user)
    {
        if ($user instanceof User) {
            return $user;
        } elseif (is_int($user)) {
            return $this->userManager->find($user);
        } else {
            return $this->userManager->findByUsernameOrEmail($user);
        }
    }
}
