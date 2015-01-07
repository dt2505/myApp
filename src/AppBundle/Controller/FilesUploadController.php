<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Response\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class FilesUploadController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * * @Rest\Post()
     */
    public function uploadFilesAction(Request $request)
    {
        return new JsonResponse("TODO: upload multiple files with dropzone and sonata media bundle");
    }
}
