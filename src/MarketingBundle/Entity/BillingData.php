<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BillingData
 *
 * @ORM\Table(name="billing_data", indexes={@ORM\Index(name="IDX_D281CDA4A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_D281CDA44584665A", columns={"product_id"})})
 * @ORM\Entity
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

    /**
     * @return PaymentSystemProducts
     */
    public function getProduct(): PaymentSystemProducts
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
     * @return json
     */
    public function getPaymentData(): json
    {
        return $this->paymentData;
    }

    /**
     * @param json $paymentData
     */
    public function setPaymentData(json $paymentData)
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



}

