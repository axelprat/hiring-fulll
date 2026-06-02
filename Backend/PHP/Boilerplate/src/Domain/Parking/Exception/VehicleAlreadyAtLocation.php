<?php

namespace Fulll\Domain\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\ValueObject\Location;
use Fulll\Domain\Parking\ValueObject\VehicleId;

class VehicleAlreadyAtLocation extends Exception implements ParkingExceptionInterface
{
    public function __construct(VehicleId $vehicleId, Location $location) {
        parent::__construct(sprintf('Vehicle %s already at location long: %s lat: %s', $vehicleId->value, $location->longitude, $location->latitude));
    }
}