<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\Then;
use Behat\Step\When;
use Exception as PendingException;
use Fulll\Domain\Parking\Entity\Fleet;
use Fulll\Domain\Parking\Entity\User;
use Fulll\Domain\Parking\Entity\Vehicle;
use Fulll\Domain\Parking\Exception\VehicleAlreadyAtLocation;
use Fulll\Domain\Parking\Exception\VehicleAlreadyOwnedException;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\Location;
use Fulll\Domain\Parking\ValueObject\UserId;
use Fulll\Domain\Parking\ValueObject\VehicleId;
use Fulll\Domain\Parking\ValueObject\VehiclePlateNumber;

class FeatureContext implements Context
{

    private ?User $user = null;
    private ?User $otherUser = null;

    private ?Fleet $myFleet = null;
    private ?Fleet $otherFleet = null;

    private ?Vehicle $myVehicle = null;

    private ?Exception $catchedException = null;

    private ?Location $location = null;

    #[Given('my fleet')]
    public function myFleet(): Fleet
    {
        return $this->getMyFleet();
    }

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser(): Fleet
    {
        return $this->getOtherFleet();
    }

    #[Given('a vehicle')]
    public function aVehicle(): Vehicle
    {
        return $this->getMyVehicle();
    }

    #[Given('a location')]
    public function aLocation(): Location
    {
        return $this->getALocation();
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet(): void
    {
        $this->myFleet->addVehicle($this->myVehicle);
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet(): bool
    {
        foreach ($this->myFleet->getVehicles() as $vehicle) {
            if ($vehicle->id === $this->myVehicle->id) {
                return true;
            }
        }

        throw new Exception('Vehicle not found in my vehicle fleet');
    }

    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $this->myFleet->addVehicle($this->myVehicle);
    }

    #[When('I try to register this vehicle into my fleet')]
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        try {
            $this->myFleet->addVehicle($this->myVehicle);
        } catch (Exception $e) {
            $this->catchedException = $e;
        }
    }

    #[Then('I should be informed this this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet(): bool
    {
        if (!$this->catchedException instanceof VehicleAlreadyOwnedException) {
            throw new Exception('VehicleAlreadyOwnedException not thrown');
        }
        if (
            $this->catchedException->getMessage() !== 'Vehicle 1 already owned by Fleet 1'
        ) {
            throw new Exception(sprintf('Wrong message for VehicleAlreadyOwnedException : %s', $this->catchedException->getMessage()));
        }

        return true;
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet(): void
    {
        $this->otherFleet->addVehicle($this->myVehicle);
    }

    #[When('I park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->myVehicle->setLocation($this->location);
    }

    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): bool
    {
        if ($this->myVehicle->getLocation() === $this->location) {
            return true;
        }

        throw new Exception(sprintf('Vehicle %s location is not long: %s lat: %s', $this->myVehicle->id, $this->location->longitude, $this->location->latitude));
    }

    #[Given('my vehicle has been parked into this location')]
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->myVehicle->setLocation($this->location);
    }

    #[When('I try to park my vehicle at this location')]
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->myVehicle->setLocation($this->location);
        } catch (Exception $e) {
            $this->catchedException = $e;
        }
    }

    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): bool
    {
        if (!$this->catchedException instanceof VehicleAlreadyAtLocation) {
            throw new Exception('VehicleAlreadyAtLocation not thrown');
        }
        if (
            $this->catchedException->getMessage() !== 'Vehicle 1 already at location long: loooooooooooong lat: lat'
        ) {
            throw new Exception(sprintf('Wrong message for VehicleAlreadyAtLocation : %s', $this->catchedException->getMessage()));
        }

        return true;
    }

    private function getUser(): User
    {
        if (null === $this->user) {
            $this->user = new User(new UserId(1));
        }

        return $this->user;
    }

    private function getMyFleet(): Fleet
    {
        if (null === $this->myFleet) {
            $user = $this->getUser();
            $this->myFleet = new Fleet(
                id: new FleetId(1),
                owner: $user
            );
        }

        return $this->myFleet;
    }

    private function getOtherUser(): User
    {
        if (null === $this->otherUser) {
            $this->otherUser = new User(new UserId(2));
        }

        return $this->otherUser;
    }

    private function getOtherFleet(): Fleet
    {
        if (null === $this->otherFleet) {
            $user = $this->getOtherUser();
            $this->otherFleet = new Fleet(
                id: new FleetId(2),
                owner: $user
            );
        }

        return $this->otherFleet;
    }

    public function getMyVehicle(): Vehicle
    {
        if (null === $this->myVehicle) {
            $this->myVehicle = new Vehicle(
                id: new VehicleId(1),
                plateNumber: new VehiclePlateNumber('AA-000-AA')
            );
        }

        return $this->myVehicle;
    }

    public function getALocation(): Location
    {
        if (null === $this->location) {
            $this->location = new Location(
                longitude: 'loooooooooooong',
                latitude: 'lat'
            );
        }

        return $this->location;
    }
}
