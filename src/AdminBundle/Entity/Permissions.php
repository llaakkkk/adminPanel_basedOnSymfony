<?php

namespace AdminBundle\Entity;

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



    /**
     * Get permId
     *
     * @return integer
     */
    public function getPermId()
    {
        return $this->permId;
    }

    /**
     * Set permDesc
     *
     * @param string $permDesc
     *
     * @return Permissions
     */
    public function setPermDesc($permDesc)
    {
        $this->permDesc = $permDesc;

        return $this;
    }

    /**
     * Get permDesc
     *
     * @return string
     */
    public function getPermDesc()
    {
        return $this->permDesc;
    }
}
