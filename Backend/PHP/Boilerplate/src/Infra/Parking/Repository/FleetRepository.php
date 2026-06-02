<?php

namespace Fulll\Infra\Parking\Repository;

use Fulll\Domain\Parking\Entity\Fleet;
use Fulll\Domain\Parking\Entity\User;
use Fulll\Domain\Parking\Entity\Vehicle;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\UserId;
use Fulll\Infra\Parking\Exception\FleetNotFoundException;

class FleetRepository extends AbstractRepository
{

    public function findById(FleetId $fleetId): Fleet
    {
        $fleet = $this->genericFindById($fleetId->value);
        if ($fleet === null) {
            throw new FleetNotFoundException(sprintf('Fleet #%s not found', $fleetId->value));
        }

        return $fleet;
    }

    public function addVehicleToFleet(Fleet $fleet, Vehicle $vehicle)
    {
        $this->prepareQuery('INSERT INTO fleet_vehicle (fleet_id, vehicle_id) VALUES (:fleetId, :vehicleId)', [
            'fleetId' => $fleet->id->value,
            'vehicleId' => $vehicle->id->value,
        ]);
    }

    public function create(UserId $userId): Fleet
    {
        $this->prepareQuery(sprintf('INSERT INTO %s (user_id) VALUES (:userId)', $this->getTableName()), ['userId' => $userId->value]);

        return $this->findById(new FleetId($this->getPdo()->lastInsertId()));
    }

    protected function getTableName(): string
    {
        return 'fleet';
    }

    protected function getEntityClass(): string
    {
        return Fleet::class;
    }

    protected function hydrate(array $row): object
    {
        $fleetId = new FleetId($row['id']);
        // This is really not good for performances due to the n+1 possible query but it's usually managed by the ORM
        $vehicleRepository = new VehicleRepository();
        $vehicles = $vehicleRepository->findByFleet($fleetId);

        return new Fleet($fleetId, new User(new UserId($row['user_id'])), ...$vehicles);
    }
}