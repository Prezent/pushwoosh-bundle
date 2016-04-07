<?php

namespace Prezent\PushwooshBundle\Manager;

/**
 * Prezent\PushwooshBundle\Manager\ManagerInterface
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
interface ManagerInterface
{
    /**
     * Send a push notification
     *
     * @param string $content
     * @param array $data
     * @param array $devices
     * @param $badge
     * @return bool
     */
    public function send($content, array $data = [], array $devices = [], $badge = false);
}