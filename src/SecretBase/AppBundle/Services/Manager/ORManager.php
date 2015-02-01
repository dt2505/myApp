<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use Doctrine\ORM\EntityManager;

abstract class ORManager extends Manager
{
    /** @var EntityManager */
    private $em;
    private $class;

    public function __construct($em, $class)
    {
        $this->em = $em;
        $this->class = $class;
    }

    /**
     * @param array $field
     * @return bool
     */
    public function exists(array $field)
    {
        $found = $this->findOneBy($field);
        return !empty($found);
    }

    /**
     * @param $entity
     */
    public function flush($entity = null)
    {
        $this->em->flush($entity);
    }

    /**
     * @param $entity
     * @param bool $flush
     */
    public function persist($entity, $flush = true)
    {
        $this->em->persist($entity);
        if ($flush) {
            $this->flush();
        }
    }

    /**
     * @param $entity
     * @param bool $andFlush
     */
    public function remove($entity, $andFlush = true)
    {
        $this->em->remove($entity);
        if ($andFlush) {
            $this->flush();
        }
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return object
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->getRepository()->findOneBy($criteria, $orderBy);
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->em->getRepository($this->class);
    }
}
