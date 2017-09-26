<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailStorage
 *
 * @ORM\Table(name="email_storage")
 * @ORM\Entity
 */
class EmailStorage
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=64, nullable=true)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="id_address", type="string", length=255, nullable=true)
     */
    private $idAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime", nullable=true)
     */
    private $registrationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=255, nullable=true)
     */
    private $browser;

    /**
     * @var string
     *
     * @ORM\Column(name="browser_version", type="string", length=255, nullable=true)
     */
    private $browserVersion;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=255, nullable=true)
     */
    private $hash;

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
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="email_storage_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;


}

