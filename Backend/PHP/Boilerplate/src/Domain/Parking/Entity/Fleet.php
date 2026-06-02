<?php

namespace Fulll\Domain\Parking\Entity;

use Fulll\Domain\Parking\Exception\VehicleAlreadyOwnedException;
use Fulll\Domain\Parking\ValueObject\FleetId;

class Fleet
{
    /**
     * @var Vehicle[] $vehicles
     */
    private array $vehicles = [];

    public function __construct(
        public readonly FleetId $id,
        public readonly User $owner,
        Vehicle ...$vehicles
    ) {
        $this->vehicles = $vehicles;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        if ($this->hasVehicle($vehicle)) {
            throw new VehicleAlreadyOwnedException(
                fleetId: $this->id,
                vehicleId: $vehicle->id,
            );
        }

        $this->vehicles[] = $vehicle;
    }

    public function hasVehicle(Vehicle $vehicle): bool
    {
        foreach ($this->vehicles as $ownedVehicle) {
            if ($vehicle->id->value === $ownedVehicle->id->value) {
                return true;
            }
        }

        return false;
    }
}