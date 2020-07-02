<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Author\AuthorController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

class HandlerInvokerTest extends TestCase
{
    public function testInvoke()
    {
        $invoker = new HandlerInvoker(
            self::getHandlerClassFactory(),
            self::getHandlerMethodArgumentsResolver()
        );

        $result = $invoker(
            new Handler(AuthorController::class, 'get', ['id' => '1']),
            $this->createMock(ServerRequestInterface::class)
        );

        $this->assertSame("AuthorController::get(1)", $result);
    }

    private static function getHandlerClassFactory(): HandlerClassFactoryInterface
    {
        return new class implements HandlerClassFactoryInterface
        {
            public function __invoke(string $class): object
            {
                return new $class();
            }
        };
    }

    private static function getHandlerMethodArgumentsResolver(): HandlerMethodArgumentsResolverInterface
    {
        return new class implements HandlerMethodArgumentsResolverInterface
        {
            public function __invoke(
                ReflectionMethod $method,
                ServerRequestInterface $request,
                PathVariables $pathVariables
            ): array {
                $args = [];
                foreach ($method->getParameters() as $param) {
                    $args[] = $pathVariables[$param->getName()];
                }
                return $args;
            }
        };
    }
}
