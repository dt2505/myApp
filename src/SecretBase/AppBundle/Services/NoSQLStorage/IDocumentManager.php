<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\NoSQLStorage;


interface IDocumentManager
{
    /**
     * @param $id
     * @return array
     */
    public function find($id);

    /**
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return array
     */
    public function findAll($orderBy = array(), $from = 0, $size = 10);

    /**
     * @param array $criteria
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return array
     */
    public function findBy(array $criteria, $orderBy = array(), $from = 0, $size = 10);

    /**
     * @param $q
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return array
     */
    public function findByQueryString($q, $orderBy = array(), $from = 0, $size = 10);

    /**
     * @param $doc
     * @param string $id
     * @param bool $refresh
     * @return array
     */
    public function persist($doc, $id = '', $refresh = true);

    /**
     * @param $id
     * @param bool $refresh
     * @return array
     */
    public function remove($id, $refresh = true);

    /**
     * @param string $index
     * @return void
     */
    public function setIndex($index);

    /**
     * @return string
     */
    public function getIndex();

    /**
     * @param string $type
     * @return void
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getType();
}
