<?php

namespace Prezent\PushwooshBundle\Log;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Gomoob\Pushwoosh\Model\Notification\Notification;
use Prezent\PushwooshBundle\Entity\LogEntry;
use Psr\Log\LoggerInterface;

/**
 * Trait containing functions to log API requests
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
trait LoggingTrait
{
    /**
     * @param LoggerInterface $logger
     * @param Notification $notification
     * @param bool $success
     * @return bool
     */
    public function logToFile(LoggerInterface $logger, Notification $notification, $success = true, array $context = [])
    {
        $data = [
            'receivers' => $notification->getDevices(),
            'content' => $notification->getContent(),
            'data' => $notification->getData(),
        ];

        $data = array_merge($data, $context);

        if ($success) {
            $logger->info('Pushmessage sent', $data);
        } else {
            $logger->error('Error sending pushmessage', $data);

        }

        return true;
    }
}
