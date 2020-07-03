<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use ArrayIterator;
use K9u\RequestMapper\Author\AuthorController;
use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class HandlerResolverTest extends TestCase
{
    public function testResolve()
    {
        $request = $this->createRequest('GET', '/authors/1');

        $handlerResolver = new HandlerResolver(new OnDemandHandlerCollector(__DIR__ . '/Fixtures'));
        $handler = $handlerResolver($request);

        $this->assertSame(AuthorController::class, $handler->class);
        $this->assertSame('get', $handler->method);
        $this->assertSame(['id' => '1'], $handler->pathParams->getIterator()->getArrayCopy());
    }

    public function testHandlerNotFound()
    {
        $this->expectException(HandlerNotFoundException::class);

        $request = $this->createRequest('GET', '/users');

        $handlerResolver = new HandlerResolver(new OnDemandHandlerCollector(__DIR__ . '/Fixtures'));
        $handlerResolver($request);
    }

    public function testMethodNotAllowed()
    {
        $this->expectException(MethodNotAllowedException::class);

        $request = $this->createRequest('DELETE', '/authors');

        $handlerResolver = new HandlerResolver(new OnDemandHandlerCollector(__DIR__ . '/Fixtures'));
        $handlerResolver($request);
    }

    private function createRequest(string $method, string $path): ServerRequestInterface
    {
        $uri = $this->createMock(UriInterface::class);
        $uri->method('getPath')->willReturn($path);

        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getMethod')->willReturn($method);
        $request->method('getUri')->willReturn($uri);

        return $request;
    }
}
