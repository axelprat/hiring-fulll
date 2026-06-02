<?php

namespace Fulll\Domain\Parking\ValueObject;

class VehiclePlateNumber
{
    public function __construct(
        public string $value
    ) {
    }
}