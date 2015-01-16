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

class Updates extends Upload
{
    /** @var StorageManager */
    private $storageManager;

    function __construct($albumManager, $photoManager, $storageManager)
    {
        parent::__construct($albumManager, $photoManager);
        $this->storageManager = $storageManager;
    }

    /**
     * @param $text
     * @param $user
     * @param array $files
     * @return ErrorResponse|JsonResponse
     */
    public function persistUpdates($text, $user, $files = array())
    {
        $response = $this->uploadPhotos($files, $user);
        if ($response instanceof ErrorResponse && $response->getCode() !== JsonResponse::OK) {
            return $response;
        }

        $storage = $this->storageManager->getDefaultStorageAdapter();
        if (!$storage) {
            return new ErrorResponse(sprintf("errors.notFound.storageAdapter|storageName:%s", $this->storageManager->getDefaultStorage()), ErrorResponse::BAD_REQUEST);
        }

        try {
            $jsonData = $this->createJson($text, $user, $response);
            $storage->save($jsonData, "updates");
        } catch (\Exception $e) {
            return new ErrorResponse($e->getMessage(), $e->getCode());
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
 