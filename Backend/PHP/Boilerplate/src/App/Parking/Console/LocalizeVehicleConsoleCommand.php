<?php

namespace Fulll\App\Parking\Console;

use Fulll\App\Parking\Command\LocalizeVehicleCommand;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\Location;
use Fulll\Domain\Parking\ValueObject\VehiclePlateNumber;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'localize-vehicle',
    description: 'change location and eventually fleet of a vehicle',
)]
class LocalizeVehicleConsoleCommand extends AbstractConsoleCommand
{
    protected function configure(): void
    {
        $this->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id')
             ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number')
             ->addArgument('long', InputArgument::REQUIRED, 'Vehicle longitude')
             ->addArgument('lat', InputArgument::REQUIRED, 'Vehicle latitude')
             ->addArgument('alt', InputArgument::OPTIONAL, 'Vehicle altitude', 0);
    }

    protected function getCommand(InputInterface $input, OutputInterface $output): LocalizeVehicleCommand
    {
        $fleetId = $input->getArgument('fleetId');
        $vehiclePlateNumber = $input->getArgument('vehiclePlateNumber');
        $long = $input->getArgument('long');
        $lat = $input->getArgument('lat');
        $alt = $input->getArgument('alt');

        return new LocalizeVehicleCommand(
            output: $output,
            fleetId: new FleetId($fleetId),
            vehiclePlateNumber: new VehiclePlateNumber($vehiclePlateNumber),
            location: new Location($long, $lat, $alt),
        );
    }

}