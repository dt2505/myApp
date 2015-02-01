<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\NoSQLStorage;

use Elastica\Client;
use Elastica\Query;
use Elastica\QueryBuilder;

class Elasticsearch implements IDocumentManager
{
    /** @var Client */
    private $client;
    private $index;
    private $type;

    public function __construct(array $config = null)
    {
        $this->client = new Client($config);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return $this->getElasticsearchType()->getDocument($id)->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll($orderBy = array(), $from = 0, $size = 10)
    {
        $resultSet = $this->search(null, $orderBy, $from, $size);
        return $resultSet->getResponse()->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria, $orderBy = array(), $from = 0, $size = 10)
    {
        if (empty($criteria)) {
            return array();
        }

        $queryStr = array();
        foreach ($criteria as $key => $value) {
            $queryStr[] = "$key:$value";
        }

        $resultSet = $this->search(join(" AND ", $queryStr), $orderBy, $from, $size);
        return $resultSet->getResponse()->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function findByQueryString($q, $orderBy = array(), $from = 0, $size = 10)
    {
        $resultSet = $this->search($q, $orderBy, $from, $size);
        return $resultSet->getResponse()->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function persist($doc, $id = '', $refresh = true)
    {
        $type = $this->getElasticsearchType();
        $type->addDocument($type->createDocument($id, $doc));
        if ($refresh) {
            $this->refresh();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove($id, $refresh = true)
    {
        $this->getElasticsearchType()->deleteById($id);
        if ($refresh) {
            $this->refresh();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param $query
     * @param array $orderBy
     * @param int $from
     * @param int $size
     * @return \Elastica\ResultSet
     */
    private function search($query, $orderBy = array(), $from = 0, $size = 10)
    {
        $q = new Query();
        $q->setFrom($from);
        $q->setSize($size);

        if (!empty($orderBy)) {
            $q->setSort($orderBy);
        }

        if (empty($query)) {
            $q->setQuery(new Query\MatchAll());
        } else {
            $qb = new QueryBuilder();
            $q->setQuery($qb->query()->query_string()->setQuery($query));
        }

        return $this->getElasticsearchType()->search($q);
    }

    /**
     * refresh
     */
    private function refresh()
    {
        $this->getElasticsearchIndex()->refresh();
    }

    /**
     * @return \Elastica\Type
     */
    private function getElasticsearchType()
    {
        return $this->getElasticsearchIndex()->getType($this->type);
    }

    /**
     * @return \Elastica\Index
     */
    private function getElasticsearchIndex()
    {
        return $this->client->getIndex($this->index);
    }
}
