<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Response;

class ErrorListResponse
{
    /** @var array */
    private $errors;

    public function __construct($errors = array())
    {
        $this->errors = $errors === null ? array() : $errors;
    }

    /**
     * @param ErrorResponse $errorResponse
     */
    public function addErrorResponse(ErrorResponse $errorResponse)
    {
        $this->errors[] = $errorResponse;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        $json = array();
        foreach ($this->errors as $error) {
            $json[] = (string)$error;
        }

        return sprintf('{"error": [%s]}', join(",", $json));
    }

    /**
     * clear errors
     */
    public function reset()
    {
        $this->errors = array();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
 