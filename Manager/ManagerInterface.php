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
     * @param       $content
     * @param array $data
     * @param array $devices
     * @param bool  $badge
     * @param null  $category
     * @param null  $condition
     * @param bool  $sound
     *
     * @return mixed
     */
    public function send($content, array $data = [], array $devices = [], $badge = false, $category = null, $condition = null, $sound = true);
}