<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="secret_base_user")
 * @ORM\Entity(repositoryClass="SecretBase\AppBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Invitation
     *
     * @ORM\OneToOne(targetEntity="Invitation", inversedBy="user")
     * @ORM\JoinColumn(referencedColumnName="code")
     */
    protected $invitation;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="secret_base_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $groups;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Album", mappedBy="owner", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $albums;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Media", mappedBy="user", cascade={"persist"}, orphanRemoval=true)
     * @ORM\OrderBy({"updatedAt" = "DESC"})
     */
    private $medias;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $qq;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $webchat;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $urban;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $street;

    /**
     * @var int
     *
     * @ORM\Column(name="post_code", type="integer", nullable=true)
     */
    private $postCode;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_picture", type="string", nullable=true)
     */
    private $profilePicture;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", nullable=true)
     */
    private $cover;

    public function __construct()
    {
        parent::__construct();
        $this->albums = new ArrayCollection();
    }

    /**
     * @return Invitation
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * @param Invitation $invitation
     */
    public function setInvitation($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }

    /**
     * @return ArrayCollection
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * @param ArrayCollection $medias
     */
    public function setMedias($medias)
    {
        $this->medias = $medias;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param mixed $groups
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return int
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param int $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * @param string $qq
     */
    public function setQq($qq)
    {
        $this->qq = $qq;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getUrban()
    {
        return $this->urban;
    }

    /**
     * @param string $urban
     */
    public function setUrban($urban)
    {
        $this->urban = $urban;
    }

    /**
     * @return mixed
     */
    public function getWebchat()
    {
        return $this->webchat;
    }

    /**
     * @param mixed $webchat
     */
    public function setWebchat($webchat)
    {
        $this->webchat = $webchat;
    }

    /**
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param string $cover
     */
    public function setCover($cover)
    {
        $this->cover = $cover;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function equal(User $user)
    {
        return $user->getId() === $this->getId() &&
                $user->getUsername() === $this->getUsername();
    }
}
 