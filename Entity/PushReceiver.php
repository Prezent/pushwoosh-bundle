<?php

namespace Prezent\PushwooshBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prezent\PushwooshBundle\Entity\PushReceiver
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>

 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="push_receiver")
 */
class PushReceiver
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="push_token", type="string")
     */
    private $pushToken;

    /**
     * @var string
     * @ORM\Column(name="device_type", type="integer")
     */
    private $deviceType;

    /**
     * @var string
     * @ORM\Column(name="identifier", type="string")
     */
    private $identifier;

    /**
     * @var string
     * @ORM\Column(name="language", type="string", length=2)
     */
    private $language;

    /**
     * @var int
     * @ORM\Column(name="timezone", type="integer")
     */
    private $timezone;

    /**
     * @var boolean
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var array
     * @ORM\Column(name="data", type="array", nullable=true)
     */
    private $data;

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
        $this->data = [];
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }

    /**
     * Getter for id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Getter for pushToken
     *
     * @return string
     */
    public function getPushToken()
    {
        return $this->pushToken;
    }

    /**
     * Setter for pushToken
     *
     * @param string $pushToken
     * @return self
     */
    public function setPushToken($pushToken)
    {
        $this->pushToken = $pushToken;
        return $this;
    }

    /**
     * Getter for deviceType
     *
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Setter for deviceType
     *
     * @param string $deviceType
     * @return self
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
        return $this;
    }

    /**
     * Getter for identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Setter for identifier
     *
     * @param string $identifier
     * @return self
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Getter for language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Setter for language
     *
     * @param string $language
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Getter for timezone
     *
     * @return int
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Setter for timezone
     *
     * @param int $timezone
     * @return self
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * Getter for active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Setter for active
     *
     * @param boolean $active
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * Getter for data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Setter for data
     *
     * @param array $data
     * @return self
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Add a new data value
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Getter for created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Getter for updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Setter for updated
     *
     * @param \DateTime $updated
     * @return self
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }
}