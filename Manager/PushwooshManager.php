<?php

namespace Prezent\PushwooshBundle\Manager;

use Gomoob\Pushwoosh\IPushwoosh;
use Gomoob\Pushwoosh\Model\Notification\Notification;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Prezent\PushwooshBundle\Exception\LoggingException;
use Prezent\PushwooshBundle\Log\LoggingTrait;
use Psr\Log\LoggerInterface;

/**
 * Prezent\SherpaTeamBundle\PushNotification\Manager
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class PushwooshManager implements ManagerInterface
{
    use LoggingTrait;

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
     * @var string
     */
    private $logging = null;

    /**
     * Constructor
     *
     * @param IPushwoosh $client
     * @param string $logging
     */
    public function __construct(IPushwoosh $client, $logging = null)
    {
        $this->client = $client;
        $this->logging = $logging;
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
            if ($this->logging) {
                // log all individual messages
                foreach ($request->getNotifications() as $notification) {
                    $this->log($notification, true);
                }
            }
            return true;
        } else {
            if ($this->logging) {
                foreach ($request->getNotifications() as $notification) {
                    $this->log(
                        $notification,
                        false,
                        ['message' => $response->getStatusMessage(), 'code' => $response->getStatusCode()]
                    );
                }
            }

            $this->errorMessage = $response->getStatusMessage();
            $this->errorCode = $response->getStatusCode();

            return false;
        }
    }

    /**
     * Log the notification
     *
     * @param Notification $notification
     * @param bool $success
     * @param array $context
     * @return bool
     * @throws LoggingException
     */
    protected function log(Notification $notification, $success = true, array $context = [])
    {
        switch ($this->logging) {
            case 'file':
                if (null === $this->logger) {
                    throw new LoggingException('No logger is set, cannot write to file');
                }

                $this->logToFile($this->logger, $notification, $success, $context);
                break;
            default:
                break;
        }

        return true;
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
     * Getter for logger
     *
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Setter for logger
     *
     * @param LoggerInterface $logger
     * @return self
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
        return $this;
    }
}
