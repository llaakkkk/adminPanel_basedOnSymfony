<?php

namespace AppBundle\Entity;

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
     * @ORM\SequenceGenerator(sequenceName="payment_system_products_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \AppBundle\Entity\PaymentSystems
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentSystems")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_system_id", referencedColumnName="id")
     * })
     */
    private $paymentSystem;


}

