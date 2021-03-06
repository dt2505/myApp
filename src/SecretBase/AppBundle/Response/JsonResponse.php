<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Response;

class JsonResponse extends Response
{
    /**
     * @return string
     */
    public function toJson()
    {
        $return = array("status" => $this->code);
        if (!empty($this->message)) {
            $return["message"] = $this->message;
        }

        return json_encode($return);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
