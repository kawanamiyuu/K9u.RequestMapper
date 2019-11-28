<?php

declare(strict_types=1);

namespace K9u\Router;

use K9u\Router\Author\AuthorController;
use K9u\Router\Exception\HandlerNotFoundException;
use K9u\Router\Exception\MethodNotAllowedException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class RouterTest extends TestCase
{
    public function testMatch()
    {
        $request = $this->createRequest('GET', '/authors/1');

        $router = new Router(new OnDemandRouteCollector(__DIR__ . '/Fixtures'));
        $handler = $router->match($request);

        $this->assertSame(AuthorController::class, $handler->class);
        $this->assertSame('get', $handler->method);
        $this->assertSame(['id' => '1'], $handler->variables);
    }

    public function testHandlerNotFound()
    {
        $this->expectException(HandlerNotFoundException::class);

        $request = $this->createRequest('GET', '/users');

        $router = new Router(new OnDemandRouteCollector(__DIR__ . '/Fixtures'));
        $router->match($request);
    }

    public function testMethodNotAllowed()
    {
        $this->expectException(MethodNotAllowedException::class);

        $request = $this->createRequest('DELETE', '/authors');

        $router = new Router(new OnDemandRouteCollector(__DIR__ . '/Fixtures'));
        $router->match($request);
    }

    private function createRequest(string $method, string $path): ServerRequestInterface
    {
        $uri = $this->prophesize(UriInterface::class);
        $uri->getPath()->willReturn($path);

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getMethod()->willReturn($method);
        $request->getUri()->willReturn($uri->reveal());

        return $request->reveal();
    }
}
