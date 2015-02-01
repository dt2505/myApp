<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Manager;

use SecretBase\AppBundle\Services\NoSQLStorage\IDocumentManager;

abstract class ODManager extends Manager
{
    /** @var IDocumentManager */
    private $idm;

    public function __construct(IDocumentManager $idm, $type)
    {
        $this->idm = $idm;
        $this->idm->setType($type);
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id)
    {
        return $this->idm->find($id);
    }

    /**
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return array
     */
    public function findAll($orderBy = array(), $from = 0, $size = 10)
    {
        return $this->idm->findAll($orderBy, $from, $size);
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return array
     */
    public function findBy(array $criteria, $orderBy = array(), $from = 0, $size = 10)
    {
        return $this->idm->findBy($criteria, $orderBy, $from, $size);
    }

    /**
     * @param $q
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return array
     */
    public function findByQueryString($q, $orderBy = array(), $from = 0, $size = 10)
    {
        return $this->idm->findByQueryString($q, $orderBy, $from, $size);
    }

    /**
     * @param $doc
     * @param string $id
     * @param bool $refresh
     */
    public function persist($doc, $id = '', $refresh = true)
    {
        $this->idm->persist($doc, $id, $refresh);
    }

    /**
     * @param $id
     * @param bool $refresh
     */
    public function remove($id, $refresh = true)
    {
        $this->idm->remove($id, $refresh);
    }
}
