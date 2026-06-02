<?php

namespace Fulll\Domain\Parking\Exception;

use Throwable;

/**
 * This interface allows us to catch or define all the domain exceptions in one go.
 * Depending on the needs we could have a VehicleExceptionInterface, FleetExceptionInterface, etc. to easily group our exceptions.
 */
interface ParkingExceptionInterface extends Throwable
{

}