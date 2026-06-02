<?php

namespace Fulll\Domain\Parking\ValueObject;

readonly class Location
{
    public function __construct(
        public string $longitude,
        public string $latitude,
    ) {
    }
}