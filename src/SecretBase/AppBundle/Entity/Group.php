<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="secret_base_group")
 * @ORM\Entity
 */
class Group extends BaseGroup
{
    const FREE = "free";
    const PAID = "paid";

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * @return string <namespace>\<class-name>
     */
    public static function getClass()
    {
        return __CLASS__;
    }
}
 