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
        public readonly User $owner
    ) {
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        foreach ($this->vehicles as $ownedVehicle) {
            if ($vehicle->id === $ownedVehicle->id) {
                throw new VehicleAlreadyOwnedException(
                    fleetId: $this->id,
                    vehicleId: $vehicle->id,
                );
            }
        }

        $this->vehicles[] = $vehicle;
    }
}