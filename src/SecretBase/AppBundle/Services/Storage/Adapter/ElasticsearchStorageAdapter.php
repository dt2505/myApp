<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Storage\Adapter;

use Elasticsearch\Client;
use SecretBase\AppBundle\Services\Storage\Storage;

class ElasticsearchStorageAdapter extends Storage
{
    const BULK_ACTION_INDEX = "index";

    /** @var  Client */
    private $client;

    public function setConfig($config)
    {
        parent::setConfig($config);
        $this->validateConfig();

        $this->client = new Client(array(
            "hosts" => array($this->getElasticsearchServer())
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function save($jsonString, $idField = null, $type = null, $overwritten = false)
    {
        if (empty($type)) {
            return array("message" => "No index type supplied.", "status" => 400);
        }
        $content = json_decode($jsonString, true);

        $param = array();
        $param["index"] = $this->getIndex();
        $param["type"] = $type;
        $param["body"] = $content;              // raw json data
        $content = json_decode($jsonString, true);
        if ($idField && isset($content[$idField])) {
            $param["id"] = $content[$idField];
        }

        try {
            $this->client->index($param);
            return array("message" => "", "status" => 200);
        } catch (\Exception $e) {
            return array("message" => $e->getMessage(), "status" => 500);
        }
    }

    /**
     * @return null|string
     */
    private function getElasticsearchServer()
    {
        $config = $this->getConfig();
        return isset($config["server"]) ? $config["server"] : null;
    }

    /**
     * @return null|string
     */
    private function getIndex()
    {
        $config = $this->getConfig();
        return isset($config["index"]) ? $config["index"] : null;
    }

    /**
     * validate each config node
     */
    private function validateConfig()
    {
        $server = $this->getElasticsearchServer();
        if (empty($server)) {
            throw new \InvalidArgumentException("No Elasticsearch Server supplied.");
        }

        $index = $this->getIndex();
        if (empty($index)) {
            throw new \InvalidArgumentException("No Elasticsearch Index supplied.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bulk(array $jsonContent, $idField, $type)
    {
        if (empty($jsonContent)) {
            return array("message" => "No records need to be indexed", "status" => 400);
        }

        if (empty($type)) {
            return array("message" => "No index type supplied.", "status" => 400);
        }

        $params = array(
            "index" => $this->getIndex(),
            "type"  => $type
        );

        $defaultId = 1;
        foreach ($jsonContent as $item) {
            if (empty($item)) {
                continue;
            }

            $content = json_decode(json_encode($item), true);

            if (empty($content)) {
                continue;
            }

            $id = isset($content[$idField]) ? $content[$idField] : $defaultId;

            $params["body"][] = array(
                self::BULK_ACTION_INDEX => array("_id" => $id)
            );

            $params["body"][] = $content;
            $defaultId++;
        }

        try {
            $response = $this->client->bulk($params);
            if ($response["errors"]) {
                $messages = array();
                foreach ($response["items"] as $item) {
                    $messages[] = sprintf(
                        "%s[%d]",
                        $item[self::BULK_ACTION_INDEX]["error"],
                        $item[self::BULK_ACTION_INDEX]["status"]
                    );
                }
                return array("message" => join("\n", $messages), "status" => 500);
            } else {
                return array("message" => "", "status" => 200);
            }
        } catch (\Exception $e) {
            return array("message" => $e->getMessage(), "status" => 500);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $query["body"] = '{
                "query": {
                    "match_all" : {}
                }
            }';
        return $this->find($query, null);
    }

    /**
     * {@inheritdoc}
     */
    public function search($what, $where, $sort = array(), $fields = array(), $from = null, $size = null)
    {
        if (empty($what)) {
            return $this->findAll();
        }
        $query['body']['query']['query_string']["query"] = $what;
        return $this->find($query, $where, $sort, $fields, $from, $size);
    }

    /**
     * @param array $query
     * @param $where
     * @param array $sort
     * @param array $fields
     * @param null $from
     * @param null $size
     * @return array
     */
    private function find(array $query, $where, $sort = array(), $fields = array(), $from = null, $size = null)
    {
        if (empty($query)) {
            return array();
        }
        $basicParams = $this->getBasicParameters($this->getIndex(), $where, $fields, $from, $size);
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
