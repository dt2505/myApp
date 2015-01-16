<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Storage;

class StorageManager
{
    private $storages;
    private $storageConfig;
    private $defaultStorage;

    public function __construct()
    {
        $this->storages = array();
    }

    /**
     * @param $alias
     * @param $reference
     */
    public function addStorage(IStorage $reference, $alias)
    {
        $this->storages[$alias] = $reference;
    }

    /**
     * @param $config
     */
    public function setStorageConfig($config)
    {
        $this->storageConfig = $config;
    }

    /**
     * @param $alias
     * @return null|IStorage
     */
    public function getStorageAdapterBy($alias)
    {
        if (!isset($this->storages[$alias])) {
            return null;
        }

        /** @var IStorage $reference */
        $reference = $this->storages[$alias];
        $reference->setConfig($this->findConfigNode($alias, $this->storageConfig));

        return $reference;
    }

    /**
     * @return null|IStorage
     */
    public function getDefaultStorageAdapter()
    {
        return $this->getStorageAdapterBy($this->defaultStorage);
    }

    /**
     * @return string
     */
    public function getDefaultStorage()
    {
        return $this->defaultStorage;
    }

    /**
     * @param string $defaultStorage
     */
    public function setDefaultStorage($defaultStorage)
    {
        $this->defaultStorage = $defaultStorage;
    }

    /**
     * @param $key
     * @param $haystack
     * @return null|array
     */
    private function findConfigNode($key, $haystack)
    {
        if (empty($haystack)) {
            return null;
        }

        return array_key_exists($key, $haystack) ? $haystack[$key] : null;
    }
}
 