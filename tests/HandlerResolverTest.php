<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Blog\BlogController;
use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class HandlerResolverTest extends TestCase
{
    private const FIXTURE_CACHE_DIR = __DIR__ . '/fixtures/cache';
    private const FIXTURE_HANDLER_DIR = __DIR__ . '/fixtures/handlers';

    public function handlerResolverProvider(): iterable
    {
        yield [new HandlerResolver(self::FIXTURE_HANDLER_DIR)];
        yield [new CachedHandlerResolver(self::FIXTURE_CACHE_DIR)];
    }

    /**
     * @dataProvider handlerResolverProvider
     */
    public function testResolve(HandlerResolverInterface $handlerResolver)
    {
        $request = $this->createRequest('GET', '/blogs/1');

        $handler = $handlerResolver($request);

        $this->assertSame(BlogController::class, $handler->getClass());
        $this->assertSame('get', $handler->getMethod());
        $this->assertSame(['id' => '1'], $handler->getPathParams()->toArray());
    }

    /**
     * @dataProvider handlerResolverProvider
     */
    public function testHandlerNotFound(HandlerResolverInterface $handlerResolver)
    {
        $this->expectException(HandlerNotFoundException::class);

        $request = $this->createRequest('GET', '/users');

        $handlerResolver($request);
    }

    /**
     * @dataProvider handlerResolverProvider
     */
    public function testMethodNotAllowed(HandlerResolverInterface $handlerResolver)
    {
        $this->expectException(MethodNotAllowedException::class);

        $request = $this->createRequest('DELETE', '/blogs');

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
