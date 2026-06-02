<?php

namespace Fulll\Infra\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\Exception\FleetNotFoundExceptionInterface;

class FleetNotFoundException extends Exception implements FleetNotFoundExceptionInterface
{

}