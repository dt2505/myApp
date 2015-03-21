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

class GirlController extends BaseController
{
    public function getGirlsAction(Request $reqeust)
    {
        return $this->render("AppBundle::girl.html.twig");
    }
}
