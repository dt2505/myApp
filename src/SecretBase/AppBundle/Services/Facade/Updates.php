<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Services\Facade;

use SecretBase\AppBundle\Response\ErrorResponse;
use SecretBase\AppBundle\Response\JsonResponse;

class Updates extends Upload
{
    /**
     * @param $text
     * @param $user
     * @param array $files
     * @return ErrorResponse|JsonResponse
     */
    public function persistUpdates($text, $user, $files = array())
    {
        $response = $this->uploadPhotos($files, $user);
        if ($response->getCode() !== JsonResponse::OK) {
            return $response;
        }

        try {
            //TODO: save it to elasticsearch
        } catch (\Exception $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
        }

        return new JsonResponse();
    }
}
 