<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * RolePermissions
 *
 * @ORM\Table(name="role_permissions", indexes={@ORM\Index(name="idx_1fba94e6d60322ac", columns={"role_id"})})
 * @ORM\Entity
 */
class RolePermissions
{
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Permissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="perm_id", referencedColumnName="perm_id")
     * })
     */
    private $perm;


}

