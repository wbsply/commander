<?php

namespace WebSupply\Commander\CommandHandler;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManager;
use Psr\EventDispatcher\EventDispatcherInterface;

#[Flow\Scope('singleton')]
final class CommandBus implements CommandBusInterface
{

    public function __construct(
        protected readonly CommandHandlerResolver $resolver,
        protected readonly ObjectManager $objectManager,
        protected readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function handle($command): void
    {
        $result = CommandResult::create();
        $resolvedHandler = $this->resolver->resolve($command::class);
        /** @var callable $handler */
        $handler = $this->objectManager->get($resolvedHandler->className);
        $handler($command, $result);

        foreach ($result->events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
