<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

use SecretBase\AppBundle\Response\JsonResponse;

class UpdatesController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Rest\Post()
     */
    public function persistUpdatesAction(Request $request)
    {
        return new JsonResponse("TODO: persist updates");
    }
}
