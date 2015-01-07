<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Response;

class ErrorResponse extends Response
{
    /**
     * @return string
     */
    public function toJson()
    {
        $return = array("code" => $this->status);
        if (!empty($this->message)) {
            $return["error"] = $this->message;
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
 