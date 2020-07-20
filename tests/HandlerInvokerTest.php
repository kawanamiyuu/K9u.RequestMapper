<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Author\AuthorController;
use K9u\RequestMapper\Author\WeavedAuthorController;
use K9u\RequestMapper\Blog\BlogController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionMethod;

class HandlerInvokerTest extends TestCase
{
    private HandlerInvokerInterface $invoker;

    protected function setUp(): void
    {
        $this->invoker = new HandlerInvoker(
            self::createHandlerClassFactory(),
            self::createHandlerMethodArgumentsResolver()
        );
    }

    public function testInvokeWeaved()
    {
        $result = ($this->invoker)(
            new Handler(AuthorController::class, 'get', ['id' => '1']),
            $this->createMock(ServerRequestInterface::class)
        );

        $this->assertSame("weaved::AuthorController::get(1)", $result);
    }

    public function testInvoke()
    {
        $result = ($this->invoker)(
            new Handler(BlogController::class, 'post', []),
            $this->createMock(ServerRequestInterface::class)
        );

        $this->assertSame("BlogController::post()", $result);
    }

    private static function createHandlerClassFactory(): HandlerClassFactoryInterface
    {
        return new class implements HandlerClassFactoryInterface
        {
            public function __invoke(string $class): object
            {
                if (is_a($class, AuthorController::class, true)) {
                    return new WeavedAuthorController();
                }

                return new $class();
            }
        };
    }

    private static function createHandlerMethodArgumentsResolver(): HandlerMethodArgumentsResolverInterface
    {
        return new class implements HandlerMethodArgumentsResolverInterface
        {
            public function __invoke(
                ReflectionMethod $method,
                ServerRequestInterface $request,
                PathParams $pathParams
            ): NamedArguments {
                $args = [];
                foreach ($method->getParameters() as $param) {
                    $args[$param->getName()] = $pathParams[$param->getName()];
                }
                return new NamedArguments($args);
            }
        };
    }
}
