<?php

namespace Fulll\App\Parking\Console;

use Fulll\App\Parking\Command\RegisterVehicleCommand;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\VehiclePlateNumber;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'register-vehicle',
    description: 'register a vehicle in a fleet',
)]
class RegisterVehicleConsoleCommand extends AbstractConsoleCommand
{
    protected function configure(): void
    {
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id')
             ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number');
    }

    protected function getCommand(InputInterface $input, OutputInterface $output): RegisterVehicleCommand
    {
        $fleetId = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');

        return new RegisterVehicleCommand($output, new FleetId($fleetId), new VehiclePlateNumber($vehiclePlateNumber));
    }

}