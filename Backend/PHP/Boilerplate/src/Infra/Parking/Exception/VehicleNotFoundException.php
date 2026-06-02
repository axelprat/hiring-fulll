<?php

namespace Fulll\Infra\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\Exception\VehicleNotFoundExceptionInterface;

class VehicleNotFoundException extends Exception implements VehicleNotFoundExceptionInterface
{

}