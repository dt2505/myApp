<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGallery;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="secret_base_gallery")
 * @ORM\Entity
 */
class Gallery extends BaseGallery
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
 