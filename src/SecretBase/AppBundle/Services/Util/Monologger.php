<?php
/**
 * This file is Copyright (c)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Util;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class Monologger extends Logger
{
    const DEFAULT_NAME = "log";

    /**
     * @param string $name
     * @param array $handlers
     * @param array $processors
     */
    function __construct($name = self::DEFAULT_NAME, array $handlers = array(), array $processors = array())
    {
        parent::__construct($name, $handlers, $processors);
    }

    /**
     * @param $logfile
     * @param int $level
     */
    public function init($logfile, $level = Logger::DEBUG)
    {
        $stream = new StreamHandler($logfile, $level);
        $stream->setFormatter(new LineFormatter("[%level_name%] %context% [%datetime%] %message%\n"));
        $this->pushHandler($stream);
    }

    /**
     * @param string $name
     * @param array $handlers
     * @param array $processors
     * @return static
     */
    public static function create($name = self::DEFAULT_NAME, array $handlers = array(), array $processors = array())
    {
        return new static($name, $handlers, $processors);
    }
}
 