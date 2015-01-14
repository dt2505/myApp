<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

use SecretBase\AppBundle\Services\Facade\Updates;
use SecretBase\AppBundle\Services\Facade\Upload;

class BaseController extends FOSRestController
{
    /**
     * @return Updates
     */
    protected function getUpdatesFacade()
    {
        return $this->get("facade.updates");
    }

    /**
     * @return Upload
     */
    protected function getUploadFacade()
    {
        return $this->get("facade.upload");
    }

    /**
     * @return TokenStorage
     */
    protected function getSecurityTokenStorage()
    {
        return $this->get('security.token_storage');
    }
}
 