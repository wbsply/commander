<?php

namespace WebSupply\Commander\CommandHandler;

use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Flow\Reflection\ReflectionService;
use Neos\Flow\Annotations as Flow;
use WebSupply\Commander\Annotations\CommandHandler;


#[Flow\Scope("singleton")]
class CommandHandlerResolver implements CommandHandlerResolverInterface {


    #[Flow\Inject]
    protected ObjectManagerInterface $objectManager;

    /**
     * @var array<string, ResolvedCommandHandler>
     */
    protected array $handlers = [];

    public function initializeObject() {
        $this->handlers = self::detectHandlers($this->objectManager);
    }

    public function getHandlers(): array
    {
        return $this->handlers;
    }

    public function resolve(string $commandName): ResolvedCommandHandler
    {
        if (!isset($this->handlers[$commandName])) {
            throw new Exception\CommandHandlerNotFoundException(sprintf('Missing handler command %s', $commandName), 1472576941);
        }
        return $this->handlers[$commandName];
    }

    #[Flow\CompileStatic]
    public static function detectHandlers(ObjectManagerInterface $objectManager): array
    {
        $handlers = [];
        /** @var ReflectionService $reflectionService */
        $reflectionService = $objectManager->get(ReflectionService::class);

        foreach ($reflectionService->getClassNamesByAnnotation(CommandHandler::class) as $commandHandlerClassName) {
            $parameters = $reflectionService->getMethodParameters($commandHandlerClassName, '__invoke');
            $command = reset($parameters);

            $handlers[$command['class']] = new ResolvedCommandHandler(
                $command['class'],
                $commandHandlerClassName
            );
        }

        return $handlers;
    }
}
