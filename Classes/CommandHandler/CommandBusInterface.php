<?php

namespace WebSupply\Commander\CommandHandler;

use Neos\Flow\ObjectManagement\ObjectManager;
use Psr\EventDispatcher\EventDispatcherInterface;

interface CommandBusInterface
{
    public function handle($command): void;
}
