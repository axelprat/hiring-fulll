<?php

namespace Fulll\Infra\Parking\Exception;

use Exception;
use Fulll\Domain\Parking\Exception\UserNotFoundExceptionInterface;

class UserNotFoundException extends Exception implements UserNotFoundExceptionInterface
{

}