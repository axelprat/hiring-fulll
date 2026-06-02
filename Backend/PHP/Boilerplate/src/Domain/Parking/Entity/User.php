<?php

namespace Fulll\Domain\Parking\Entity;

use Fulll\Domain\Parking\Exception\FleetAlreadyOwnedException;
use Fulll\Domain\Parking\Exception\FleetHasOwnerException;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\UserId;

class User
{
    private array $fleets = [];

    public function __construct(
        public readonly UserId $id
    ) {
    }

    public function getFleets(): array
    {
        return $this->fleets;
    }

    public function getFleet(FleetId $fleetId): array
    {
        return $this->fleets;
    }

    /**
     * @param Fleet $fleet
     *
     * @return void
     *
     * @throws FleetAlreadyOwnedException
     * @throws FleetHasOwnerException
     */
    public function addFleet(Fleet $fleet): void
    {
        if ($fleet->owner->id !== $this->id) {
            throw new FleetHasOwnerException(
                userId: $this->id,
                fleetId: $fleet->id
            );
        }

        foreach ($this->fleets as $ownedFleet) {
            if ($fleet->id === $ownedFleet->id) {
                throw new FleetAlreadyOwnedException(
                    userId: $this->id,
                    fleetId: $fleet->id
                );
            }
        }

        $this->fleets[] = $fleet;
    }
}