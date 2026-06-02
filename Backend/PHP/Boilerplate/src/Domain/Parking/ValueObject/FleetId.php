<?php

namespace Fulll\Domain\Parking\ValueObject;

readonly class FleetId
{
    public function __construct(
        public int $value
    ) {
    }
}