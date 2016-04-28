<?php

namespace Prezent\PushwooshBundle\Manager;

use Gomoob\Pushwoosh\IPushwoosh;
use Gomoob\Pushwoosh\Model\Notification\Notification;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var bool
     */
    private $logRequests = false;

    /**
     * Constructor
     *
     * @param IPushwoosh $client
     * @param LoggerInterface $logger
     */
    public function __construct(IPushwoosh $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function send($content, array $data = [], array $devices = [])
    {
        $notification = $this->createNotification($content, $data, $devices);

        $request = new CreateMessageRequest();
        $request->addNotification($notification);

        return $this->sendPush($request);
    }

    /**
     * {@inheritdoc}
     */
    public function sendBatch(array $notifications)
    {
        $request = new CreateMessageRequest();
        foreach ($notifications as $notificationArray) {
            $content = isset($notificationArray['content']) ? $notificationArray['content'] : '';
            $data = isset($notificationArray['data']) ? $notificationArray['data'] : [];
            $devices = isset($notificationArray['devices']) ? $notificationArray['devices'] : [];

            if ($content) {
                $notification = $this->createNotification($content, $data, $devices);
                $request->addNotification($notification);
            }
        }

        return $this->sendPush($request);
    }

    /**
     * Create a notification for the request
     *
     * @param string $content
     * @param array $data
     * @param array $devices
     * @return Notification
     */
    private function createNotification($content, array $data = [], array $devices = [])
    {
        $notification = new Notification();
        $notification->setContent($content);

        if (!empty($data)) {
            $notification->setData($data);
        }

        if (!empty($devices)) {
            $notification->setDevices($devices);
        }

        return $notification;
    }

    /**
     * Send the push message with client
     *
     * @param CreateMessageRequest $request
     * @return boolean
     */
    private function sendPush(CreateMessageRequest $request)
    {
        // Call the REST Web Service
        $response = $this->client->createMessage($request);

        // Check if its ok
        if ($response->isOk()) {

            if ($this->logRequests) {
                // log all individual messages
                foreach ($request->getNotifications() as $notification) {
                    $this->logger->info('Pushmessage sent', $notification->jsonSerialize());
                }
            }

            return true;
        } else {

            if ($this->logRequests) {
                $this->logger->error(
                    'Error sending pushmessage',
                    ['message' => $response->getStatusMessage(), 'code' => $response->getStatusCode()]
                );
            }

            $this->errorMessage = $response->getStatusMessage();
            $this->errorCode = $response->getStatusCode();

            return false;
        }
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

    /**
     * Setter for logRequests
     *
     * @param boolean $logRequests
     * @return self
     */
    public function setLogRequests($logRequests)
    {
        $this->logRequests = $logRequests;
        return $this;
    }
}
