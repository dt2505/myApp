<?php
/**
 * This file is Copyright (c).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SecretBase\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Acl\Model\DomainObjectInterface;

/**
 * @ORM\Table(name="secret_base_invitation")
 * @ORM\Entity
 */
class Invitation implements DomainObjectInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=15)
     * @ORM\Id
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * When sending invitation be sure to set this value to `true`
     *
     * It can prevent invitations from being sent twice
     *
     * @ORM\Column(type="boolean")
     */
    protected $sent = false;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy="invitation", cascade={"persist", "merge"})
     */
    protected $user;

    public function __construct()
    {
        $this->code = substr(md5(uniqid(rand(), true)), 0, 15);
    }

    /**
     * @return  string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return Invitation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return  bool
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * Flag the invitation email as being sent
     */
    public function send()
    {
        $this->sent = true;
    }

    /**
     * @return  User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Invitation
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param   boolean $sent
     * @return  Invitation
     */
    public function setSent($sent)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * @return  boolean
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Function used to give Symfony a unique identifier which is required because there is no getId function
     *
     * @return  string
     */
    public function getObjectIdentifier()
    {
        return $this->getCode();
    }
}
 