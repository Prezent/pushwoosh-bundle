<?php

namespace Prezent\PushwooshBundle\Command;

use Gomoob\Pushwoosh\IPushwoosh;
use Gomoob\Pushwoosh\Model\Notification\Notification;
use Gomoob\Pushwoosh\Model\Request\CreateMessageRequest;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Prezent\SherpaTeamBundle\Command\SendPushNotificationCommand
 *
 * @author Robert-Jan Bijl <robert-jan@prezent.nl>
 */
class SendPushCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('push:send')
            ->setDescription('Send a push message')
            ->addArgument('message', InputArgument::REQUIRED, 'The message to send')
            ->addOption(
                'tokens',
                't',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                'List of push token to send the notification to',
                []
            )
            ->setHelp('Send a push message')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var IPushwoosh $pushwoosh */
        $pushwoosh = $this->getContainer()->get('pushwoosh');
        $request = $this->createRequest($input->getArgument('message'), $input->getOption('tokens'));

        // Call the REST Web Service
        $response = $pushwoosh->createMessage($request);

        // Check if its ok
        if ($response->isOk()) {
            $output->writeln('<info>Message send successful</info>');
        } else {
            $output->writeln('<error>Message could not be send</error>');
            $output->writeln(
                sprintf(
                    '<error>[%d] %s</error>',
                    $response->getStatusCode(),
                    $response->getStatusMessage()
                )
            );
        }

        return 0;
    }

    /**
     * Create the request to send the push
     *
     * @param string $content
     * @param array $devices
     * @return CreateMessageRequest
     */
    private function createRequest($content, array $devices = [])
    {
        $notification = new Notification();
        $notification->setContent($content);

        if (!empty($devices)) {
            $notification->setDevices($devices);
        }

        $request = new CreateMessageRequest();
        $request->addNotification($notification);

        return $request;
    }
}