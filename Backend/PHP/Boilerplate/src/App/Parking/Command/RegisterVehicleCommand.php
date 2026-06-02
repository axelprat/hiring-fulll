<?php

namespace Fulll\App\Parking\Command;

use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\VehiclePlateNumber;
use Symfony\Component\Console\Output\OutputInterface;

readonly class RegisterVehicleCommand
{
    public function __construct(
        public OutputInterface $output,
        public FleetId $fleetId,
        public VehiclePlateNumber $vehiclePlateNumber,
    ) {
    }
}