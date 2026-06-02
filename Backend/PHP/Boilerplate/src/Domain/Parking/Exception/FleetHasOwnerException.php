<?php

namespace Fulll\Domain\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\UserId;

class FleetHasOwnerException extends Exception implements ParkingExceptionInterface
{
    public function __construct(UserId $userId, FleetId $fleetId) {
        parent::__construct(sprintf('User %s cannot own fleet %s which already has an owner', $userId->value, $fleetId->value));
    }
}