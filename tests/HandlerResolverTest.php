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

    /**
     * @dataProvider dataProvider
     */
    public function testResolve(HandlerResolverInterface $handlerResolver, array $request, array $expect)
    {
        $request = $this->createRequest($request[0], $request[1]);

        $handler = $handlerResolver($request);

        $this->assertSame($expect[0], $handler->getClass());
        $this->assertSame($expect[1], $handler->getMethod());
        $this->assertSame($expect[2], $handler->getPathParams()->toArray());
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

    public function handlerResolverProvider(): iterable
    {
        yield [new HandlerResolver(self::FIXTURE_HANDLER_DIR)];
        yield [new CachedHandlerResolver(self::FIXTURE_CACHE_DIR)];
    }

    public function dataProvider(): iterable
    {
        $data = [
            [
                ['GET', '/blogs'],                   // request
                [BlogController::class, 'index', []] // handler to be resolved
            ],
            [
                ['GET', '/blogs/1'],
                [BlogController::class, 'get', ['id' => '1']]
            ],
            [
                ['POST', '/blogs'],
                [BlogController::class, 'post', []]
            ],
            [
                ['PUT', '/blogs/1'],
                [BlogController::class, 'put', ['id' => '1']]
            ],
            [
                ['PATCH', '/blogs/1'],
                [BlogController::class, 'patch', ['id' => '1']]
            ],
            [
                ['DELETE', '/blogs/1'],
                [BlogController::class, 'delete', ['id' => '1']]
            ]
        ];

        foreach ($this->handlerResolverProvider() as [$handlerResolver]) {
            foreach ($data as [$request, $expect]) {
                yield [$handlerResolver, $request, $expect];
            }
        }
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
