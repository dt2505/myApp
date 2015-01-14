<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Storage;

interface IStorage
{
    /**
     * @param array $config
     */
    public function setConfig($config);

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param $jsonString
     * @param null $idField
     * @param null $type
     * @param bool $overwritten
     * @return array["message"]
     *              ["status"]
     */
    public function save($jsonString, $idField = null, $type = null, $overwritten = false);

    /**
     * @param array $jsonContent
     * @param string $idField
     * @param string $type
     * @return array["message"]
     *              ["status"]
     */
    public function bulk(array $jsonContent, $idField, $type);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param string $what ({field}:{value} OR|AND {field}:{value}) OR|AND {field}:{value}
     * @param $where
     * @param array $sort
     * @param array $fields what fields should be returned
     * @param null $from
     * @param null $size
     * @return array
     */
    public function search($what, $where, $sort = array(), $fields = array(), $from = null, $size = null);
}
 