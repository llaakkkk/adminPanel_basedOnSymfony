<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\SubscriptionStatus;

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
     * @ORM\Column(name="number_of_cores", type="integer", nullable=true)
     */
    private $numberOfCores;

    /**
     * @var string
     *
     * @ORM\Column(name="hard_drive_type", type="string", length=8, nullable=true)
     */
    private $hardDriveType;

    /**
     * @var integer
     *
     * @ORM\Column(name="hard_drive_capacity", type="integer", nullable=true)
     */
    private $hardDriveCapacity;

    /**
     * @var string
     *
     * @ORM\Column(name="processor_model", type="string", length=32, nullable=true)
     */
    private $processorModel;

    /**
     * @var string
     *
     * @ORM\Column(name="os_version", type="string", length=16, nullable=true)
     */
    private $osVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="os_build", type="string", length=16, nullable=true)
     */
    private $osBuild;

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
     *  @ORM\ManyToMany(targetEntity="LanguagesToUserDevices", mappedBy="userDevice")
     *  @ORM\JoinTable(
     *  name="LanguagesToUserDevices",
     *  joinColumns={
     *      @ORM\JoinColumn(name="user_device_id", referencedColumnName="id")
     *  },
     *   inverseJoinColumns={
     *  @ORM\JoinColumn(name="id", referencedColumnName="id")
     *   }
     * )

     */

    private $deviceLanguage;

    /**
     * @ORM\OneToMany(targetEntity="MarketingBundle\Entity\BillingData", mappedBy="userDevice")
     * @ORM\JoinColumn(name="id", referencedColumnName="user_device_id")
     */
    private $billingData;

//    /**
//     * @ORM\ManyToOne(targetEntity="MarketingBundle\Entity\BillingData", inversedBy="userDevice")
//     * @ORM\JoinColumn(name="user_device_id", referencedColumnName="id")
//     */

//    private $billingData;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
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
    public function getNumberOfCores(): int
    {
        return $this->numberOfCores;
    }

    /**
     * @param int $numberOfCores
     */
    public function setNumberOfCores(int $numberOfCores)
    {
        $this->numberOfCores = $numberOfCores;
    }

    /**
     * @return string
     */
    public function getHardDriveType(): string
    {
        return $this->hardDriveType;
    }


    public function setHardDriveType(string $hardDriveType)
    {
        $this->hardDriveType = $hardDriveType;
    }


    public function getHardDriveCapacity()
    {
        return $this->hardDriveCapacity;
    }

    /**
     * @param int $hardDriveCapacity
     */
    public function setHardDriveCapacity(int $hardDriveCapacity)
    {
        $this->hardDriveCapacity = $hardDriveCapacity;
    }

    /**
     * @return string
     */
    public function getProcessorModel(): string
    {
        return $this->processorModel;
    }

    /**
     * @param string $processorModel
     */
    public function setProcessorModel(string $processorModel)
    {
        $this->processorModel = $processorModel;
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
    public function getOsBuild()
    {
        return $this->osBuild;
    }

    /**
     * @param string $osBuild
     */
    public function setOsBuild(string $osBuild)
    {
        $this->osBiuld = $osBuild;
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
    public function getActivationKey()
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


    public function setIsTest($isTest)
    {
        $this->isTest = $isTest;
    }


    public function getIsHidden()
    {
        return $this->isHidden;
    }


    public function setIsHidden($isHidden)
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
    public function setSubscriptionStatus($subscriptionStatus)
    {
        $this->subscriptionStatus = $subscriptionStatus;
    }

    public function getDeviceLanguage()
    {
        return $this->deviceLanguage;
    }


    public function setDeviceLanguage($deviceLanguage)
    {
        $this->deviceLanguage = $deviceLanguage;
    }
}

