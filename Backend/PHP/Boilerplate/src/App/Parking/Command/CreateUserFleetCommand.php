<?php

namespace Fulll\App\Parking\Command;

use Fulll\Domain\Parking\ValueObject\UserId;
use Symfony\Component\Console\Output\OutputInterface;

readonly class CreateUserFleetCommand
{
    public function __construct(
        public OutputInterface $output,
        public UserId $userId,
    ) {
    }
}