<?php

namespace AppBundle\Entity;

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
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_tracking_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;


}

