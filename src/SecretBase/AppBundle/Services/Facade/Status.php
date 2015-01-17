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
use SecretBase\AppBundle\Services\Storage\StorageManager;

class Status extends Upload
{
    const ES_IDX_TYPE_STATUS = "status";

    /** @var StorageManager */
    private $storageManager;

    function __construct($albumManager, $imageManager, $storageManager)
    {
        parent::__construct($albumManager, $imageManager);
        $this->storageManager = $storageManager;
    }

    /**
     * @param $text
     * @param $user
     * @param array $files
     * @return ErrorResponse|array
     */
    public function persistStatus($text, $user, $files = array())
    {
        $response = $this->uploadImages($files, $user);
        if ($response instanceof ErrorResponse && $response->getCode() !== JsonResponse::OK) {
            return $response;
        }

        $storage = $this->storageManager->getDefaultStorageAdapter();
        if (!$storage) {
            return new ErrorResponse(sprintf("errors.notFound.storageAdapter|storageName:%s", $this->storageManager->getDefaultStorage()), ErrorResponse::BAD_REQUEST);
        }

        $jsonData = $this->createJson($text, $user, $response);
        $response = $storage->save($jsonData, self::ES_IDX_TYPE_STATUS);
        if ($response instanceof ErrorResponse) {
            return $response;
        }

        return new JsonResponse();
    }

    private function createJson($text, $user, $medias)
    {
        $data = array(
            "users" => array(),
            "medias" => array(),
            "text" => $text,
            "createdAt" => new \DateTime()
        );

        return json_encode($data);
    }
}
 