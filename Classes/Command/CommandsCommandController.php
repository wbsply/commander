<?php

namespace WebSupply\Commander\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Symfony\Component\Console\Helper\TableSeparator;
use WebSupply\Commander\CommandHandler\CommandHandlerResolverInterface;
use WebSupply\Commander\CommandHandler\ResolvedCommandHandler;

final class CommandsCommandController extends CommandController
{
    public function __construct(
        protected readonly CommandHandlerResolverInterface $commandHandlerResolver
    )
    {
        parent::__construct();
    }

    public function listCommand(string $command = null)
    {
        $rows = [];
        /**
         * @var string $command
         * @var ResolvedCommandHandler $handler
         */
        foreach ($this->commandHandlerResolver->getHandlers() as $commandClassName => $handler)
        {
            if ($command !== null && $commandClassName !== $command) {
                continue;
            }

            $rows[] = [
                $commandClassName,
                sprintf("%s", $handler->className)
            ];
        }
        $this->output->outputTable(
            rows: $rows,
            headers: ['Command', 'Handler'],
            headerTitle: 'Command and corresponding handler'
        );
    }
}
