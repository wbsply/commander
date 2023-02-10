<?php

namespace WebSupply\Commander\CommandHandler;

use Neos\Flow\Annotations as Flow;

#[Flow\Proxy(false)]
class ResolvedCommandHandler
{
    public function __construct(
        public readonly string $command,
        public readonly string $className
    ) {}
}
