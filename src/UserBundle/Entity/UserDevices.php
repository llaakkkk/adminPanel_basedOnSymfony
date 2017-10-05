<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use  UserBundle\Entity\SubscriptionStatus;
/**
 * UserDevices
 *
 * @ORM\Table(name="user_devices")
 *  @ORM\Entity(repositoryClass="UserBundle\Repository\UserDevicesRepository")
 */
// * @ORM\Index(name="IDX_490A50905948C201", columns={"subscription_status_id"})


class UserDevices
{

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
     * @ORM\Column(name="memory_frequency", type="integer", nullable=true)
     */
    private $memoryFrequency;

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
     * @var string
     *
     * @ORM\Column(name="serial_number", type="string", length=255, nullable=true)
     */
    private $serialNumber;

   /**
     * @var boolean
     *
     * @ORM\Column(name="is_test", type="boolean", nullable=false, columnDefinition="false")
     */
    private $isTest;

   /**
     * @var boolean
     *
     * @ORM\Column(name="is_hidden", type="boolean", nullable=false, columnDefinition="false")
     */
    private $isHidden;

   /**
     * @var string
     *
     * @ORM\Column(name="application_build_version", type="string", length=64, nullable=true)
     */
    private $applicationBuildVersion;


    /**
     * @var \UserBundle\Entity\SubscriptionStatus
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\SubscriptionStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="subscription_status_id", referencedColumnName="id")
     * })
     */
    private $subscriptionStatus;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * @param string $modelName
     */
    public function setModelName(string $modelName)
    {
        $this->modelName = $modelName;
    }

    /**
     * @return string
     */
    public function getModelNumber(): string
    {
        return $this->modelNumber;
    }

    /**
     * @param string $modelNumber
     */
    public function setModelNumber(string $modelNumber)
    {
        $this->modelNumber = $modelNumber;
    }

    /**
     * @return int
     */
    public function getMemoryCapacity(): int
    {
        return $this->memoryCapacity;
    }

    /**
     * @param int $memoryCapacity
     */
    public function setMemoryCapacity(int $memoryCapacity)
    {
        $this->memoryCapacity = $memoryCapacity;
    }

    /**
     * @return int
     */
    public function getMemoryFrequency(): int
    {
        return $this->memoryFrequency;
    }

    /**
     * @param int $memoryFrequency
     */
    public function setMemoryFrequency(int $memoryFrequency)
    {
        $this->memoryFrequency = $memoryFrequency;
    }

    /**
     * @return string
     */
    public function getHarddriveType(): string
    {
        return $this->harddriveType;
    }

    /**
     * @param string $harddriveType
     */
    public function setHarddriveType(string $harddriveType)
    {
        $this->harddriveType = $harddriveType;
    }

    /**
     * @return int
     */
    public function getHarddriveCapacity(): int
    {
        return $this->harddriveCapacity;
    }

    /**
     * @param int $harddriveCapacity
     */
    public function setHarddriveCapacity(int $harddriveCapacity)
    {
        $this->harddriveCapacity = $harddriveCapacity;
    }

    /**
     * @return string
     */
    public function getProccessorModel(): string
    {
        return $this->proccessorModel;
    }

    /**
     * @param string $proccessorModel
     */
    public function setProccessorModel(string $proccessorModel)
    {
        $this->proccessorModel = $proccessorModel;
    }

    /**
     * @return string
     */
    public function getOsVersion(): string
    {
        return $this->osVersion;
    }

    /**
     * @param string $osVersion
     */
    public function setOsVersion(string $osVersion)
    {
        $this->osVersion = $osVersion;
    }

    /**
     * @return string
     */
    public function getOsBiuld(): string
    {
        return $this->osBiuld;
    }

    /**
     * @param string $osBiuld
     */
    public function setOsBiuld(string $osBiuld)
    {
        $this->osBiuld = $osBiuld;
    }

    /**
     * @return string
     */
    public function getMacAddress(): string
    {
        return $this->macAddress;
    }

    /**
     * @param string $macAddress
     */
    public function setMacAddress(string $macAddress)
    {
        $this->macAddress = $macAddress;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName(string $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     */
    public function setUuid(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }


    /**
     * @return string
     */
    public function getActivationKey(): string
    {
        return $this->activationKey;
    }

    /**
     * @param string $activationKey
     */
    public function setActivationKey(string $activationKey)
    {
        $this->activationKey = $activationKey;
    }


    public function getIsTest()
    {
        return $this->isTest;
    }


    public function setIsTest(boolean $isTest)
    {
        $this->isTest = $isTest;
    }


    public function getIsHidden()
    {
        return $this->isHidden;
    }


    public function setIsHidden(boolean $isHidden)
    {
        $this->isHidden = $isHidden;
    }

    public function getSerialNumber()
    {
        return $this->serialNumber;
    }


    public function setSerialNumber(string $serialNumber)
    {
        $this->serialNumber = $serialNumber;
    }


    public function getApplicationBuildVersion()
    {
        return $this->applicationBuildVersion;
    }


    public function setApplicationBuildVersion(string $applicationBuildVersion)
    {
        $this->applicationBuildVersion = $applicationBuildVersion;
    }

    /**
     * @return \UserBundle\Entity\SubscriptionStatus
     */
    public function getSubscriptionStatus()
    {
        return $this->subscriptionStatus;
    }

    /**
     * @param  \UserBundle\Entity\SubscriptionStatus $subscriptionStatus
     */
    public function setSubscriptionStatus( $subscriptionStatus)
    {
        $this->subscriptionStatus = $subscriptionStatus;
    }

}

