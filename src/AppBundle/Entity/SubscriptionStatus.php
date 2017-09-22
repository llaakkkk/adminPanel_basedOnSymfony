<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubscriptionStatus
 *
 * @ORM\Table(name="subscription_status", indexes={@ORM\Index(name="IDX_B2F67D9B4584665A", columns={"product_id"}), @ORM\Index(name="IDX_B2F67D9BD3B6F523", columns={"license_status_id"})})
 * @ORM\Entity
 */
class SubscriptionStatus
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="next_charge_date", type="datetime", nullable=true)
     */
    private $nextChargeDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'now()';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated = 'now()';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="subscription_status_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\PaymentSystemProducts
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentSystemProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \AppBundle\Entity\LicenseStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\LicenseStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="license_status_id", referencedColumnName="id")
     * })
     */
    private $licenseStatus;


}

