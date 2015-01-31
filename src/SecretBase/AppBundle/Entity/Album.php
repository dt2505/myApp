<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="secret_base_album")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Album
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
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="albums")
     * @ORM\JoinColumn(name="owner_id",referencedColumnName="id")
     */
    private $owner;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_default", type="boolean")
     */
    private $default;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Media", mappedBy="album", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"updatedAt" = "DESC"})
     */
    private $medias;

    public function __construct($name, $owner = null)
    {
        $this->medias = array();
        $this->name =$name;
        $this->owner = $owner;
        $this->default = false;
    }

    /**
     * @return string
     */
    public static function getClass()
    {
        return __CLASS__;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param array $medias
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
    }

    /**
     * @param Media $media
     * @return bool
     */
    public function addMedia(Media $media)
    {
        if (!$this->mediaExists($media)) {
            $media->setAlbum($this);
            $this->medias[] = $media;
        } else {
            return false;
        }
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param boolean $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * @param Media $media
     * @return bool
     */
    private function mediaExists(Media $media)
    {
        /** @var Media $value */
        foreach ($this->medias as $value) {
            if ($media->getId() === $value->getId() &&
                $media->getName() === $media->getName() &&
                $media->getSize() === $value->getSize()) {
                return true;
            }
        }

        return false;
    }
}
