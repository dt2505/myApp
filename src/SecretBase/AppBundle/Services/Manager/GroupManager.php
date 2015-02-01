<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Entity\Group;

class GroupManager extends ORManager
{
    public function __construct($em)
    {
        parent::__construct($em, Group::getClass());
    }

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
     * @return Group
     */
    public function findFreeGroup()
    {
        return $this->findOneBy(array("name" => Group::FREE));
    }

    /**
     * @param $name
     * @param $andPersist
     * @return Group
     * @throws \Exception
     */
    public function createGroup($name, $andPersist)
    {
        $group = new Group($name);
        if ($andPersist) {
            if (!$this->exists(array("name" => $name))) {
                $this->persist($group);
            } else {
                throw new \Exception("errors.found.group");
            }
        }

        return $group;
    }
}
