<?php

namespace AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AdminBundle\Entity\Roles as Roles;
use AdminBundle\Entity\Permissions as Permissions;

/**
 * RolePermissions
 *
 * @ORM\Table(name="role_permissions", indexes={@ORM\Index(name="idx_1fba94e6d60322ac", columns={"role_id"})})
 * @ORM\Entity
 */
class RolePermissions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="role_perm_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="role_permissions_role_perm_id_seq", allocationSize=1, initialValue=1)
     */
    private $rolePermId;

    /**
     * @var \Roles
     *
     * @ORM\ManyToOne(targetEntity="Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="role_id")
     * })
     */
    private $role;

    /**
     * @var \Permissions
     *
     * @ORM\ManyToOne(targetEntity="Permissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perm_id", referencedColumnName="perm_id")
     * })
     */
    private $perm;

    /**
     * Get permId
     *
     * @return integer
     */
    public function getRolePermId()
    {
        return $this->rolePermId;
    }


    /**
     * Set role
     *
     * @param \AdminBundle\Entity\Roles $role
     *
     * @return RolePermissions
     */
    public function setRole(Roles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \AdminBundle\Entity\Roles
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set perm
     *
     * @param \AdminBundle\Entity\Permissions $perm
     *
     * @return RolePermissions
     */
    public function setPerm(Permissions $perm)
    {
        $this->perm = $perm;

        return $this;
    }

    /**
     * Get perm
     *
     * @return \AdminBundle\Entity\Permissions
     */
    public function getPerm()
    {
        return $this->perm;
    }
}
