<?php
/**
 * This file is Copyright (c) Ladoo Pty Ltd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Component\User\Entity;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /** @var int */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}
 