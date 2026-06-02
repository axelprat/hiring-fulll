<?php

namespace Fulll\App\Parking\CommandHandler;

use Fulll\App\Parking\Command\CreateUserFleetCommand;
use Fulll\Infra\Parking\Repository\FleetRepository;
use Fulll\Infra\Parking\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserFleetCommandHandler
{
    public function __invoke(CreateUserFleetCommand $command) {
        // Usually this would be required in constructor and manager by dependency injector
        $userRepository = new UserRepository();
        $fleetRepository = new FleetRepository();

        $user = $userRepository->findById($command->userId);
        $fleet = $fleetRepository->create($user->id);

        $command->output->writeln(sprintf('<success>Fleet #%s created for user #%s</success>', $fleet->id->value, $command->userId->value));
    }
}