<?php

namespace Fulll\Domain\Parking\Entity;

use Fulll\Domain\Parking\Exception\VehicleAlreadyAtLocation;
use Fulll\Domain\Parking\ValueObject\Location;
use Fulll\Domain\Parking\ValueObject\VehicleId;
use Fulll\Domain\Parking\ValueObject\VehiclePlateNumber;

class Vehicle
{
    /**
     * I usually prefer numerical ID and uniq column for something else (like a plate number) but I'm open to discussion
     *
     * @param VehicleId $id
     * @param VehiclePlateNumber $plateNumber
     * @param Location|null $location
     */
    public function __construct(
        public readonly VehicleId $id,
        public readonly VehiclePlateNumber $plateNumber,
        private ?Location $location = null,
    ) {
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    /**
     * @param Location $location
     *
     * @return void
     *
     * @throws VehicleAlreadyAtLocation
     */
    public function setLocation(Location $location): void
    {
        if (
            $this->location !== null
            && $this->location->longitude === $location->longitude
            && $this->location->latitude === $location->latitude
        ) {
            throw new VehicleAlreadyAtLocation(vehicleId: $this->id, location: $location);
        }

        $this->location = $location;
    }
}