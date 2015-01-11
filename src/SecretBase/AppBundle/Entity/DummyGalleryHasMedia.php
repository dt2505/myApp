<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use Sonata\MediaBundle\Entity\BaseGalleryHasMedia;
use Doctrine\ORM\Mapping as ORM;

/**
 * GalleryHasMedia is useless but SonataMediaBundle requires this entity to build one-to-many
 * relationship between gallery and media
 *
 * @ORM\Table(name="secret_base_dummy_gallery_has_media")
 * @ORM\Entity
 */
class DummyGalleryHasMedia extends BaseGalleryHasMedia
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
 