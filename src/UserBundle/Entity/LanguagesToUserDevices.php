<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\UserDevices;

/**
 * LanguagesToUserDevices
 *
 * @ORM\Table(name="languages_to_user_devices", indexes={@ORM\Index(name="IDX_57DE8CC782F1BAF4", columns={"language_id"}), @ORM\Index(name="IDX_57DE8CC794444A30", columns={"user_device_id"})})
 * @ORM\Entity
 */
class LanguagesToUserDevices
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="languages_to_user_devices_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \UserBundle\Entity\Languages
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Languages")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * })
     */
    private $language;

    /**
     * @var \UserBundle\Entity\UserDevices
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\UserDevices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_device_id", referencedColumnName="id")
     * })
     */
    private $userDevice;




    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Languages
     */
    public function getLanguage(): Languages
    {
        return $this->language;
    }

    /**
     * @param Languages $language
     */
    public function setLanguage(Languages $language)
    {
        $this->language = $language;
    }

    /**
     * @return \UserBundle\Entity\UserDevices
     */
    public function getUserDevice(): UserDevices
    {
        return $this->userDevice;
    }

    /**
     * @param \UserBundle\Entity\UserDevices $userDevice
     */
    public function setUserDevice(UserDevices $userDevice)
    {
        $this->userDevice = $userDevice;
    }

}

