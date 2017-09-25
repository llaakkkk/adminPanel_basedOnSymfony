<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use  AppBundle\Entity\SubscriptionStatus;
/**
 * UserDevices
 *
 * @ORM\Table(name="user_devices", indexes={@ORM\Index(name="IDX_490A50905948C201", columns={"subscription_status_id"})})
 * @ORM\Entity
 */
class UserDevices
{
    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="model_name", type="string", length=255, nullable=true)
     */
    private $modelName;

    /**
     * @var string
     *
     * @ORM\Column(name="model_number", type="string", length=255, nullable=true)
     */
    private $modelNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="memory_capacity", type="integer", nullable=true)
     */
    private $memoryCapacity;

    /**
     * @var integer
     *
     * @ORM\Column(name="memore_frequency", type="integer", nullable=true)
     */
    private $memoreFrequency;

    /**
     * @var string
     *
     * @ORM\Column(name="harddrive_type", type="string", length=8, nullable=true)
     */
    private $harddriveType;

    /**
     * @var integer
     *
     * @ORM\Column(name="harddrive_capacity", type="integer", nullable=true)
     */
    private $harddriveCapacity;

    /**
     * @var string
     *
     * @ORM\Column(name="proccessor_model", type="string", length=32, nullable=true)
     */
    private $proccessorModel;

    /**
     * @var string
     *
     * @ORM\Column(name="os_version", type="string", length=16, nullable=true)
     */
    private $osVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="os_biuld", type="string", length=16, nullable=true)
     */
    private $osBiuld;

    /**
     * @var string
     *
     * @ORM\Column(name="mac_address", type="string", length=255, nullable=true)
     */
    private $macAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=255, nullable=true)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=255, nullable=true)
     */
    private $uuid;

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
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=true)
     */
    private $activationKey;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_devices_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \UserBundle\Entity\SubscriptionStatus
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\SubscriptionStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_status_id", referencedColumnName="id")
     * })
     */
    private $subscriptionStatus;


}

