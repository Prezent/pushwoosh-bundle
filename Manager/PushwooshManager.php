<?php

namespace Prezent\PushwooshBundle\Manager;

use Gomoob\Pushwoosh\IPushwoosh;
use Gomoob\Pushwoosh\Model\Notification\Notification;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;

/**
 * Prezent\SherpaTeamBundle\PushNotification\Manager
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class PushwooshManager implements ManagerInterface
{
    /**
     * @var IPushwoosh
     */
    private $client;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var int
     */
    private $errorCode;

    /**
     * Constructor
     *
     * @param IPushwoosh $client
     */
    public function __construct(IPushwoosh $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function send($content, array $data = [], array $devices = [])
    {
        $request = $this->createRequest($content, $data, $devices);

        // Call the REST Web Service
        $response = $this->client->createMessage($request);

        // Check if its ok
        if ($response->isOk()) {
            return true;
        } else {
            $this->errorMessage = $response->getStatusMessage();
            $this->errorCode = $response->getStatusCode();
            return false;
        }
    }

    /**
     * Create the request to send the push
     *
     * @param string $content
     * @param array $data
     * @param array $devices
     * @return CreateMessageRequest
     */
    private function createRequest($content, array $data = [], array $devices = [])
    {
        $notification = new Notification();
        $notification->setContent($content);

        if (!empty($data)) {
            $notification->setData($data);
        }

        if (!empty($devices)) {
            $notification->setDevices($devices);
        }

        $request = new CreateMessageRequest();
        $request->addNotification($notification);

        return $request;
    }

    /**
     * Getter for errorMessage
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Getter for errorCode
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}