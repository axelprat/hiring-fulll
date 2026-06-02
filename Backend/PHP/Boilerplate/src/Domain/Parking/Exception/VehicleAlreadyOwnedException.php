<?php

namespace Fulll\Domain\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\VehicleId;

class VehicleAlreadyOwnedException extends Exception implements ParkingExceptionInterface
{
    public function __construct(FleetId $fleetId, VehicleId $vehicleId) {
        parent::__construct(sprintf('Vehicle %s already owned by Fleet %s', $vehicleId->value, $fleetId->value));
    }
}