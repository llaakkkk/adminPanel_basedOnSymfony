<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTracking
 *
 * @ORM\Table(name="user_tracking")
 * @ORM\Entity
 */
class UserTracking
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_tracking_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;


    /**
     * @var integer
     *
     * @ORM\Column(name="user_device_id", type="integer", nullable=true)
     */
    private $userDeviceId;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255, nullable=true)
     */
    private $hash;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255, nullable=true)
     */
    private $domain;

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=255, nullable=true)
     */
    private $clientId;

    /**
     * @var string
     *
     * @ORM\Column(name="g_click_id", type="string", length=255, nullable=true)
     */
    private $gClickId;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_source", type="string", length=255, nullable=true)
     */
    private $utmSource;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_medium", type="string", length=255, nullable=true)
     */
    private $utmMedium;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_campaign", type="string", length=255, nullable=true)
     */
    private $utmCampaign;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_adgroup", type="string", length=255, nullable=true)
     */
    private $utmAdgroup;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_term", type="string", length=255, nullable=true)
     */
    private $utmTerm;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_matchtype", type="string", length=255, nullable=true)
     */
    private $utmMatchtype;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_content", type="string", length=255, nullable=true)
     */
    private $utmContent;

    /**
     * @var string
     *
     * @ORM\Column(name="utm_device", type="string", length=255, nullable=true)
     */
    private $utmDevice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=false)
     */
    private $updated = 'now()';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created = 'now()';



    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserDeviceId(): int
    {
        return $this->userDeviceId;
    }

    /**
     * @param int $userDeviceId
     */
    public function setUserDeviceId(int $userDeviceId)
    {
        $this->userDeviceId = $userDeviceId;
    }


    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return string
     */
    public function getDomain(): string
    {
        return $this->domain;
    }


    /**
     * @param string $hash
     */
    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @param string $domain
     */
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
    }



    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getGClickId(): string
    {
        return $this->gClickId;
    }

    /**
     * @param string $gClickId
     */
    public function setGClickId(string $gClickId)
    {
        $this->gClickId = $gClickId;
    }

    /**
     * @return string
     */
    public function getUtmSource(): string
    {
        return $this->utmSource;
    }

    /**
     * @param string $utmSource
     */
    public function setUtmSource(string $utmSource)
    {
        $this->utmSource = $utmSource;
    }

    /**
     * @return string
     */
    public function getUtmMedium(): string
    {
        return $this->utmMedium;
    }

    /**
     * @param string $utmMedium
     */
    public function setUtmMedium(string $utmMedium)
    {
        $this->utmMedium = $utmMedium;
    }

    /**
     * @return string
     */
    public function getUtmCampaign(): string
    {
        return $this->utmCampaign;
    }

    /**
     * @param string $utmCampaign
     */
    public function setUtmCampaign(string $utmCampaign)
    {
        $this->utmCampaign = $utmCampaign;
    }

    /**
     * @return string
     */
    public function getUtmAdgroup(): string
    {
        return $this->utmAdgroup;
    }

    /**
     * @param string $utmAdgroup
     */
    public function setUtmAdgroup(string $utmAdgroup)
    {
        $this->utmAdgroup = $utmAdgroup;
    }
    /**
     * @return string
     */
    public function getUtmTerm(): string
    {
        return $this->utmTerm;
    }

    /**
     * @param string $utmTerm
     */
    public function setUtmTerm(string $utmTerm)
    {
        $this->utmTerm = $utmTerm;
    }

    /**
     * @return string
     */
    public function getUtmMatchtype(): string
    {
        return $this->utmMatchtype;
    }

    /**
     * @param string $utmMatchtype
     */
    public function setUtmMatchtype(string $utmMatchtype)
    {
        $this->utmMatchtype = $utmMatchtype;
    }


    /**
     * @return string
     */
    public function getUtmContent(): string
    {
        return $this->utmContent;
    }
    /**
     * @param string $utmContent
     */
    public function setUtmContent(string $utmContent)
    {
        $this->utmContent = $utmContent;
    }

    /**
     * @return string
     */
    public function getUtmDevice(): string
    {
        return $this->utmDevice;
    }

    /**
     * @param string $utmDevice
     */
    public function setUtmDevice(string $utmDevice)
    {
        $this->utmDevice = $utmDevice;
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

