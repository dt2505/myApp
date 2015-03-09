<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

class GalleryController extends BaseController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function getGalleryAction(Request $request)
    {
        return $this->render("AppBundle::gallery.html.twig");
    }
}
