<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Permissions
 *
 * @ORM\Table(name="permissions")
 * @ORM\Entity
 */
class Permissions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="perm_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="permissions_perm_id_seq", allocationSize=1, initialValue=1)
     */
    private $permId;

    /**
     * @var string
     *
     * @ORM\Column(name="perm_desc", type="string", length=50, nullable=false)
     */
    private $permDesc;


}

