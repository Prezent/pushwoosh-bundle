<?php

namespace Prezent\PushwooshBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gomoob\Pushwoosh\Model\Notification\Platform;

/**
 * Prezent\PushwooshBundle\Entity\PushReceiver
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>

 * @ORM\MappedSuperclass
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
     * @ORM\Column(name="timezone", type="integer", nullable=true)
     */
    private $timezone;

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
     * @return Platform
     */
    public function getDeviceType()
    {
        switch ($this->deviceType) {
            case 1:
                return Platform::iOS();
                break;
            case 2:
                return Platform::blackBerry();
                break;
            case 3:
                return Platform::android();
                break;
            case 4:
                return Platform::nokia();
                break;
            case 5:
                return Platform::windowsPhone7();
                break;
            case 7:
                return Platform::macOSX();
                break;
            case 8:
                return Platform::windows8();
                break;
            case 9:
                return Platform::amazon();
                break;
            case 10:
                return Platform::safari();
                break;
        }

        throw new \RuntimeException('Not a valid device type set');
    }

    /**
     * Setter for deviceType
     *
     * @param Platform $deviceType
     * @return self
     */
    public function setDeviceType(Platform $deviceType)
    {
        $this->deviceType = $deviceType->getValue();
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
}