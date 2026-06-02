<?php

namespace Fulll\App\Parking\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;

abstract class AbstractConsoleCommand extends Command
{

    public function __construct(
        private readonly MessageBusInterface $commandBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->commandBus->dispatch($this->getCommand($input, $output));

            return Command::SUCCESS;
        } catch (HandlerFailedException $e) {
            $cause = $e->getPrevious() ?? $e;
            $output->writeln(sprintf('<error>[%s] %s</error>', $cause::class, $cause->getMessage()));

            return Command::FAILURE;
        } catch (Throwable $e) {
            $output->writeln(sprintf('<error>Unexpected error : %s</error>', $e->getMessage()));

            return Command::FAILURE;
        }
    }

    abstract protected function getCommand(InputInterface $input, OutputInterface $output): mixed;
}
