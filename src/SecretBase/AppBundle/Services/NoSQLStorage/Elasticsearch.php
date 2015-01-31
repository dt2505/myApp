<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\NoSQLStorage;

use Elasticsearch\Client;

class Elasticsearch
{
    const BULK_ACTION_INDEX = "index";

    /** @var  Client */
    private $client;
    /** @var string */
    private $index;
    /** @var string */
    private $type;

    public function __construct($server, $index, $type)
    {
        $this->client = new Client(array(
            "hosts" => array($server)
        ));

        $this->index = $index;
        $this->type =$type;
    }

    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param $content
     * @param string $idField
     * @param string $index
     * @param string $type
     */
    public function save($content, $idField = null, $index = null, $type = null)
    {
        $decodedContent = json_decode($content, true);

        $param = array();
        $param["index"] = $index ? $index : $this->getIndex();
        $param["type"] = $type ? $type : $this->getType();
        $param["body"] = $content;

        if ($idField && isset($decodedContent[$idField])) {
            $param["id"] = $decodedContent[$idField];
        }

        $this->client->index($param);
    }

    /**
     * @param array $jsonContent
     * @param string $idField
     * @throws \Exception
     */
    public function bulk(array $jsonContent, $idField = null)
    {
        if (empty($jsonContent)) {
            return;
        }

        $params = array(
            "index" => $this->getIndex(),
            "type"  => $this->getType()
        );

        foreach ($jsonContent as $item) {
            if (empty($item)) {
                continue;
            }

            $content = json_decode(json_encode($item), true);

            if (empty($content)) {
                continue;
            }

            if ($idField) {
                $id = isset($content[$idField]) ? $content[$idField] : null;
            } else {
                $id = null;
            }

            if ($id) {
                $params["body"][] = array(
                    self::BULK_ACTION_INDEX => array("_id" => $id)
                );
            } else {
                $params["body"][] = array(
                    self::BULK_ACTION_INDEX => array()
                );
            }

            $params["body"][] = $content;
        }

        $response = $this->client->bulk($params);
        if ($response["errors"]) {
            throw new \Exception(json_encode($response["items"]));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($index, $type)
    {
        $query["body"] = '{
                "query": {
                    "match_all" : {}
                }
            }';
        return $this->find($query, $index, $type);
    }

    /**
     * @param $what
     * @param $index
     * @param $type
     * @param array $sort
     * @param array $fields
     * @param null $from
     * @param null $size
     * @return array
     */
    public function search($what, $index, $type, $sort = array(), $fields = array(), $from = null, $size = null)
    {
        if (empty($what)) {
            return $this->findAll($index, $type);
        }
        $query['body']['query']['query_string']["query"] = $what;
        return $this->find($query, $index, $type, $sort, $fields, $from, $size);
    }

    /**
     * @param array $query
     * @param $index
     * @param $type
     * @param array $sort
     * @param array $fields
     * @param null $from
     * @param null $size
     * @return array
     */
    private function find(array $query, $index, $type, $sort = array(), $fields = array(), $from = null, $size = null)
    {
        if (empty($query)) {
            return array();
        }
        $basicParams = $this->getBasicParameters($index, $type, $fields, $from, $size);
        if (empty($basicParams)) {
            return array();
        }

        $param = array_merge($basicParams, $query);
        if (!empty($sort)) {
            $sortStr = array();
            foreach ($sort as $key => $value) {
                $sortStr[] = "$key:$value";
            }

            $param["sort"] = join(",", $sortStr);
        }
        return $this->client->search($param);
    }

    /**
     * @param $index
     * @param $type
     * @param array $fieldsToReturn
     * @param int $from
     * @param int $size
     * @throws \InvalidArgumentException
     * @return array
     */
    private function getBasicParameters($index, $type, $fieldsToReturn = array(), $from = null, $size = null)
    {
        if (empty($index) || empty($type)) {
            return null;
        }

        $range = array();
        if ($from > 0) {
            $range["from"] = $from;
        }
        if ($size > 0) {
            $range["size"] = $size;
        }

        $params = array_merge(array(), $range);
        if (!empty($fieldsToReturn)) {
            $params["fields"] = $fieldsToReturn;
        }

        return array_merge(
            array(
                "index"     => $index,
                "type"      => $type
            ),
            $params
        );
    }
}
