<?php

namespace WebSupply\Commander\CommandHandler;

use Neos\Flow\Annotations as Flow;


interface CommandHandlerResolverInterface {

    public function getHandlers(): array;
    public function resolve(string $commandName): ResolvedCommandHandler;

}
