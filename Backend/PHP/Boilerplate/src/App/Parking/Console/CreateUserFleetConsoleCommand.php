<?php

namespace Fulll\App\Parking\Console;

use Fulll\App\Parking\Command\CreateUserFleetCommand;
use Fulll\Domain\Parking\ValueObject\UserId;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'create',
    description: 'Create a user fleet',
)]
class CreateUserFleetConsoleCommand extends AbstractConsoleCommand
{
    protected function configure(): void
    {
        $this->addArgument('userId', InputArgument::REQUIRED, 'User Id');
    }

    protected function getCommand(InputInterface $input, OutputInterface $output): CreateUserFleetCommand
    {
        $userId = $input->getArgument('userId');

        return new CreateUserFleetCommand($output, new UserId($userId));
    }

}