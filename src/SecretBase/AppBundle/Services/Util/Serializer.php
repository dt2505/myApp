<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Util;

use JMS\Serializer\SerializerBuilder;

class Serializer
{
    /**
     * @param $obj
     * @param string $format
     * @return mixed
     */
    public static function serialize($obj, $format = "json")
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->serialize($obj, $format);
    }

    /**
     * @param $data
     * @param $type
     * @param string $format
     * @return mixed
     */
    public static function deserialize($data, $type, $format = "json")
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->deserialize($data, $type, $format);
    }
}
