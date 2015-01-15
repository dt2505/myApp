<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Storage;

abstract class Storage implements IStorage
{
    /** @var  string */
    private $config;

    /**
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param string $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }
}
 