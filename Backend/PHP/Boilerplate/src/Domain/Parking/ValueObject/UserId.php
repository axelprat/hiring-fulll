<?php

namespace Fulll\Domain\Parking\ValueObject;

readonly class UserId
{
    public function __construct(
        public int $value
    ) {
    }
}