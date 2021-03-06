<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\Users;
/**
 * BillingData
 *
 * @ORM\Table(name="billing_data", indexes={@ORM\Index(name="IDX_D281CDA4A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_D281CDA44584665A", columns={"product_id"}), @ORM\Index(name="IDX_D281CDA494444A30", columns={"user_device_id"}), @ORM\Index(name="IDX_D281CDA43D8C939E", columns={"promo_code"}), @ORM\Index(name="IDX_D281CDA45AA1164F", columns={"payment_method_id"})})
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\BillingDataRepository")
 */
class BillingData
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="billing_data_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

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
     * @var json
     *
     * @ORM\Column(name="payment_data", type="json", nullable=true)
     */
    private $paymentData;

    /**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer", nullable=true)
     */
    private $orderId;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="event_type", type="string", length=255, nullable=true)
     */
    private $eventType;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

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
     * @var \UserBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="promo_code", type="integer", nullable=true)
     */
    private $promoCode;

    /**
     * @var \UserBundle\Entity\UserDevices
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\UserDevices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_device_id", referencedColumnName="id")
     * })
     */
    private $userDevice;

    /**
     * @var \MarketingBundle\Entity\PaymentMethods
     *
     * @ORM\ManyToOne(targetEntity="MarketingBundle\Entity\PaymentMethods")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_method_id", referencedColumnName="id")
     * })
     */
    private $paymentMethod;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \UserBundle\Entity\Users
     */
    public function getUser(): \UserBundle\Entity\Users
    {
        return $this->user;
    }

    /**
     * @param \UserBundle\Entity\Users $user
     */
    public function setUser(\UserBundle\Entity\Users $user)
    {
        $this->user = $user;
    }


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


    public function getPaymentData()
    {
        return $this->paymentData;
    }


    public function setPaymentData($paymentData)
    {
        $this->paymentData = $paymentData;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     */
    public function setEventType(string $eventType)
    {
        $this->eventType = $eventType;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
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

    /**
     * @return \UserBundle\Entity\Users
     */
    public function getUserId(): \UserBundle\Entity\Users
    {
        return $this->userId;
    }

    /**
     * @param \UserBundle\Entity\Users $userId
     */
    public function setUserId(\UserBundle\Entity\Users $userId)
    {
        $this->userId = $userId;
    }

    public function getPromoCode()
    {
        return $this->promoCode;
    }


    public function setPromoCode($promoCode)
    {
        $this->promoCode = $promoCode;
    }


    public function getUserDevice()
    {
        return $this->userDevice;
    }

    /**
     * @param \UserBundle\Entity\UserDevices $userDevice
     */
    public function setUserDevice(\UserBundle\Entity\UserDevices $userDevice)
    {
        $this->userDevice = $userDevice;
    }

    /**
     * @return PaymentMethods
     */
    public function getPaymentMethod(): PaymentMethods
    {
        return $this->paymentMethod;
    }

    /**
     * @param PaymentMethods $paymentMethod
     */
    public function setPaymentMethod(PaymentMethods $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }




}

