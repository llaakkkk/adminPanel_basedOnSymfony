<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\LicenseTypes;

/**
 * PaymentSystemProducts
 *
 * @ORM\Table(name="payment_system_products", indexes={@ORM\Index(name="IDX_DDD8077B2C55C7C8", columns={"license_type_id"}), @ORM\Index(name="IDX_DDD8077B93BC008D", columns={"payment_system_id"})})
 * @ORM\Entity
 */
class PaymentSystemProducts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="payment_system_products_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="product_id", type="string", length=32, nullable=true)
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @var \UserBundle\Entity\LicenseTypes
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\LicenseTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="license_type_id", referencedColumnName="id")
     * })
     */
    private $licenseType;

    /**
     * @var \MarketingBundle\Entity\PaymentSystems
     *
     * @ORM\ManyToOne(targetEntity="MarketingBundle\Entity\PaymentSystems")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_system_id", referencedColumnName="id")
     * })
     */
    private $paymentSystem;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @param string $productId
     */
    public function setProductId(string $productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return  \UserBundle\Entity\LicenseTypes
     */
    public function getLicenseType(): \UserBundle\Entity\LicenseTypes
    {
        return $this->licenseType;
    }

    /**
     * @param  \UserBundle\Entity\LicenseTypes $licenseType
     */
    public function setLicenseType(\UserBundle\Entity\LicenseTypes $licenseType)
    {
        $this->licenseType = $licenseType;
    }

    /**
     * @return PaymentSystems
     */
    public function getPaymentSystem(): PaymentSystems
    {
        return $this->paymentSystem;
    }

    /**
     * @param PaymentSystems $paymentSystem
     */
    public function setPaymentSystem(PaymentSystems $paymentSystem)
    {
        $this->paymentSystem = $paymentSystem;
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

