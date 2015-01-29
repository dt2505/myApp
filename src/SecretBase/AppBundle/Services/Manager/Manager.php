<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use Doctrine\ORM\EntityManager;

abstract class Manager
{
    /** @var EntityManager */
    private $em;
    private $class;

    public function __construct($em, $class = null)
    {
        $this->em = $em;
        $this->class = $class;
    }

    protected function exists($class, array $field)
    {
        $found = $this->em->getRepository($class)->findOneBy($field);
        return !empty($found);
    }

    public function persist($entity, $andFlush = true)
    {
        $this->em->persist($entity);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function remove($entity, $andFlush = true)
    {
        $this->em->remove($entity);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function getRepository($name)
    {
        return $this->em->getRepository($name);
    }
}
