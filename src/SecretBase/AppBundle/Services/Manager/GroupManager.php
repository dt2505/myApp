<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Entity\Group;

class GroupManager extends Manager
{
    /**
     * @param bool $andPersist
     * @return Group
     */
    public function createFreeGroup($andPersist = false)
    {
        return $this->createGroup(Group::FREE, $andPersist);
    }

    /**
     * @param bool $andPersist
     * @return Group
     */
    public function createPaidGroup($andPersist = false)
    {
        return $this->createGroup(Group::PAID, $andPersist);
    }

    /**
     * @param $name
     * @param $andPersist
     * @return Group
     */
    private function createGroup($name, $andPersist)
    {
        if ($group = $this->getRepository(Group::getClass())->findOneBy(array("name" => $name))) {
            return $group;
        }

        $group = new Group($name);
        if ($andPersist) {
            $this->persist($group);
        }

        return $group;
    }
}
