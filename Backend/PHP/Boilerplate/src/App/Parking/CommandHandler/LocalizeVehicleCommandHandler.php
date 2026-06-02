<?php

namespace Fulll\App\Parking\CommandHandler;

use Fulll\App\Parking\Command\LocalizeVehicleCommand;
use Fulll\Infra\Parking\Exception\VehicleNotFoundException;
use Fulll\Infra\Parking\Repository\FleetRepository;
use Fulll\Infra\Parking\Repository\VehicleRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class LocalizeVehicleCommandHandler
{
    public function __invoke(LocalizeVehicleCommand $command) {
        // Usually this would be required in constructor and manager by dependency injector
        $fleetRepository = new FleetRepository();
        $vehicleRepository = new VehicleRepository();

        $fleet = $fleetRepository->findById($command->fleetId);
        $vehicle = $vehicleRepository->findByPlateNumber($command->vehiclePlateNumber);

        if (!$fleet->hasVehicle($vehicle)) {
            throw new VehicleNotFoundException(sprintf(
                'Vehicle #%s (%s) not found in fleet #%s',
                $vehicle->id->value,
                $vehicle->plateNumber->value,
                $fleet->id->value
            ));
        }
        $vehicle->setLocation($command->location);
        $vehicleRepository->persist($vehicle);

        $command->output->writeln(sprintf(
            '<success>Vehicle #%s (%s) set to location long %s lat %s alt %s</success>',
            $vehicle->id->value,
            $vehicle->plateNumber->value,
            $vehicle->getLocation()->longitude,
            $vehicle->getLocation()->latitude,
            $vehicle->getLocation()->altitude
        ));
    }
}