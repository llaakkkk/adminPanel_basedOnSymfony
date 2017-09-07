<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AdminUser
 *
 * @ORM\Table(name="admin_user")
 * @ORM\Entity(repositoryClass="AdminBundle\Repository\AdminUserRepository")
 * @UniqueEntity(fields={"email"}, message="This one is already taken")
 */
class AdminUser implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     *
     *
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"Registration"})
     */
    private $plainPassword;

    /**
     * @var integer
     *
     * @ORM\Column(name="roles", type="json_array", nullable=true)
     */
    private $roles = ['ROLE_SUPPORT'];


    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated;


    public function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $username
     *
     * @return AdminUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {

        $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AdminUser
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Set password
     *
     * @param string $password
     *
     * @return AdminUser
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword() {

        return $this->password;
    }


    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_ADMIN');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {

        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = 'ROLE_SUPPORT';
        }

//        foreach ($this->groups as $group) {
//            $roles = array_merge($roles, $group->getRoles());
//        }

        return $roles;

    }


    public function setRoles($roles)
    {
        $this->roles = $roles;
    }


    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }


    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {

    }



    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;

    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }


    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        //guarantees that the entity looks "dirty" to Doctrine
        // when changing the plainPassword
        $this->password = null;
    }





}
