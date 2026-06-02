<?php

namespace Fulll\App\Parking\CommandHandler;

use Fulll\App\Parking\Command\RegisterVehicleCommand;
use Fulll\Infra\Parking\Repository\FleetRepository;
use Fulll\Infra\Parking\Repository\VehicleRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RegisterVehicleCommandHandler
{
    public function __invoke(RegisterVehicleCommand $command) {
        // Usually this would be required in constructor and manager by dependency injector
        $fleetRepository = new FleetRepository();
        $vehicleRepository = new VehicleRepository();

        $fleet = $fleetRepository->findById($command->fleetId);
        $vehicle = $vehicleRepository->findByPlateNumber($command->vehiclePlateNumber);

        $fleet->addVehicle($vehicle);
        // here we should call $fleetRepository->persist($fleet); instead but then again there is no advanced ORM here
        $fleetRepository->addVehicleToFleet($fleet, $vehicle);

        $command->output->writeln(sprintf(
            '<success>Vehicle #%s (%s) added to fleet #%s</success>',
            $vehicle->id->value,
            $vehicle->plateNumber->value,
            $fleet->id->value
        ));
    }
}