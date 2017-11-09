<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\PaymentSystemProducts;

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
     * @var \MarketingBundle\Entity\PaymentSystemProducts
     *
     * @ORM\ManyToOne(targetEntity="MarketingBundle\Entity\PaymentSystemProducts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * })
     */
    private $product;

    /**
     * @var \UserBundle\Entity\LicenseStatus
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\LicenseStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="license_status_id", referencedColumnName="id")
     * })
     */
    private $licenseStatus;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

//    /**
//     * @return PaymentSystemProducts
//     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param PaymentSystemProducts $product
     */
    public function setProduct(PaymentSystemProducts $product)
    {
        $this->product = $product;
    }

    /**
     * @return LicenseStatus
     */
    public function getLicenseStatus(): LicenseStatus
    {
        return $this->licenseStatus;
    }

    /**
     * @param LicenseStatus $licenseStatus
     */
    public function setLicenseStatus(LicenseStatus $licenseStatus)
    {
        $this->licenseStatus = $licenseStatus;
    }


    /**
     * @return \DateTime
     */
    public function getNextChargeDate(): \DateTime
    {
        return $this->nextChargeDate;
    }

    /**
     * @param \DateTime $nextChargeDate
     */
    public function setNextChargeDate(\DateTime $nextChargeDate)
    {
        $this->nextChargeDate = $nextChargeDate;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }


    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

}

