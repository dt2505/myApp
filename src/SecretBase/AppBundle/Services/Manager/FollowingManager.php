<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Entity\Following;

class FollowingManager extends ORManager
{
    public function __construct($em)
    {
        parent::__construct($em, Following::getClass());
    }

    /**
     * @return Following
     */
    public function create()
    {
        return new Following();
    }

    /**
     * @param array $criteria
     */
    public function removeBy(array $criteria)
    {
        if ($followings = $this->findBy($criteria)) {
            foreach ($followings as $following) {
                parent::remove($following, false);
            }

            parent::flush();
        }
    }

    /**
     * @param $user
     * @return array<User>
     */
    public function getFollowers($user)
    {
        if ($followings = $this->findBy(array("following" => $user))) {
            $followers = array();
            /** @var Following $following */
            foreach ($followings as $following)
            {
                $followers[] = $following->getUser();
            }

            return $followers;
        } else {
            return array();
        }
    }

    /**
     * @param $user
     * @return array<User>
     */
    public function getFollowings($user)
    {
        if ($results = $this->findBy(array("user" => $user))) {
            $followings = array();
            /** @var Following $result */
            foreach ($results as $result)
            {
                $followings[] = $result->getFollowing();
            }

            return $followings;
        } else {
            return array();
        }
    }
}
