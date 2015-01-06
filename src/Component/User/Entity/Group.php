<?php
/**
 * This file is Copyright (c) Ladoo Pty Ltd.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Component\User\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;

class Group extends BaseGroup
{
    /** @var int */
    protected $id;

    public function __construct($name)
    {
        parent::__construct($name);
    }
}
 