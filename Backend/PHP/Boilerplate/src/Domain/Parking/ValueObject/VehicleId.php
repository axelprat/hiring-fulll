<?php

namespace Fulll\Domain\Parking\ValueObject;

readonly class VehicleId
{
    public function __construct(
        public int $value
    ) {
    }
}