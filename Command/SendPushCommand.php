<?php

namespace Prezent\PushwooshBundle\Command;

use Prezent\PushwooshBundle\Manager\PushwooshManager;
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
            ->setDescription('Send a push message manually')
            ->addArgument('message', InputArgument::REQUIRED, 'The message to send')
            ->addOption(
                'tokens',
                't',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL,
                'List of push token to send the notification to',
                []
            )
            ->setHelp('Send a push message manually')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var PushwooshManager $pushwooshManager */
        $pushwooshManager = $this->getContainer()->get('prezent_pushwoosh.pushwoosh_manager');
        $success = $pushwooshManager->send($input->getArgument('message'), [], $input->getOption('tokens'));

        // Check if its ok
        if ($success) {
            $output->writeln('<info>Push message send successful</info>');
        } else {
            $output->writeln('<error>Push message could not be send</error>');
            $output->writeln(
                sprintf(
                    '<error>[%d] %s</error>',
                    $pushwooshManager->getErrorCode(),
                    $pushwooshManager->getErrorMessage()
                )
            );
        }

        return 0;
    }
}