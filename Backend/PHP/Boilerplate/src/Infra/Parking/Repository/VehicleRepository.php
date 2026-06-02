<?php

namespace Fulll\Infra\Parking\Repository;

use Fulll\Domain\Parking\Entity\Vehicle;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\Location;
use Fulll\Domain\Parking\ValueObject\VehicleId;
use Fulll\Domain\Parking\ValueObject\VehiclePlateNumber;
use Fulll\Infra\Parking\Exception\VehicleNotFoundException;

class VehicleRepository extends AbstractRepository
{

    public function findByPlateNumber(VehiclePlateNumber $plateNumber): Vehicle
    {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE plate_number = :plate_number";
        $vehicle = $this->fetchOne($sql, ['plate_number' => $plateNumber->value]);
        if ($vehicle === null) {
            throw new VehicleNotFoundException(sprintf('Vehicle %s not found', $plateNumber->value));
        }

        return $vehicle;
    }

    /**
     * @param FleetId $fleetId
     *
     * @return Vehicle[]
     */
    public function findByFleet(FleetId $fleetId): array
    {
        $sql = "SELECT v.* FROM {$this->getTableName()} v INNER JOIN fleet_vehicle fv ON fv.vehicle_id = v.id WHERE fv.fleet_id = :fleet_id";

        return $this->fetchAll($sql, ['fleet_id' => $fleetId->value]);
    }

    public function persist(Vehicle $vehicle): Vehicle
    {
        $sql = "UPDATE {$this->getTableName()} SET `long` = :long, `lat` = :lat, alt = :alt WHERE id = :id";
        $this->prepareQuery($sql, [
            'long' => $vehicle->getLocation()->longitude,
            'lat' => $vehicle->getLocation()->latitude,
            'alt' => $vehicle->getLocation()->latitude,
            'id' => $vehicle->id->value,
        ]);

        return $this->genericFindById($vehicle->id->value);
    }

    protected function getTableName(): string
    {
        return 'vehicle';
    }

    protected function getEntityClass(): string
    {
        return Vehicle::class;
    }

    protected function hydrate(array $row): Vehicle
    {
        $location = null;
        if (isset($row['long']) && isset($row['lat'])) {
            $location = new Location($row['long'], $row['lat'], $row['alt'] ?? null);
        }

        return new Vehicle(
            id: new VehicleId($row['id']),
            plateNumber: new VehiclePlateNumber($row['plate_number']),
            location: $location,
        );
    }
}