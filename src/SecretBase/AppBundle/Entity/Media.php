<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Entity\BaseMedia;

/**
 * @ORM\Table(name="secret_base_media")
 * @ORM\Entity
 */
class Media extends BaseMedia
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
     * @var Album
     * @ORM\ManyToOne(targetEntity="Album", inversedBy="medias")
     * @ORM\JoinColumns={
     *      @ORM\JoinColumn(name="album_id", referencedColumnName="id"),
     *      @ORM\JoinColumn(name="owner_id", referencedColumnName="owner_id")
     * }
     */
    private $album;

    /**
     * @return string
     */
    public static function getClass()
    {
        return __CLASS__;
    }

    /**
     * @return Album
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
 