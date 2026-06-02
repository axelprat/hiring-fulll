<?php

namespace Fulll\Domain\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\ValueObject\FleetId;
use Fulll\Domain\Parking\ValueObject\UserId;

class FleetAlreadyOwnedException extends Exception implements ParkingExceptionInterface
{
    public function __construct(UserId $userId, FleetId $fleetId) {
        parent::__construct(sprintf('Fleet %s already owned by user %s', $fleetId->value, $userId->value));
    }
}