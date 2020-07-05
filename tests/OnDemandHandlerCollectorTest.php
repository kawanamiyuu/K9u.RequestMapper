<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Author\AuthorController;
use K9u\RequestMapper\Blog\BlogController;
use PHPUnit\Framework\TestCase;

class OnDemandHandlerCollectorTest extends TestCase
{
    /**
     * @dataProvider expectsProvider
     *
     * @param array $expects expects
     */
    public function testCollect(array $expects)
    {
        $collector = new OnDemandHandlerCollector(__DIR__ . '/Fixtures');
        $collection = $collector();

        $this->assertSame(12, $collection->count());

        $results = [];
        foreach ($collection as $route) {
            $results[] = [
                $route->getPath(),
                $route->getMethods(),
                $route->getDefaults()
            ];
        }

        $this->assertSame($expects, $results);
    }

    public function expectsProvider()
    {
        $expects = [
            // author
            [
                '/authors',
                ['GET'],
                ['_handler_class' => AuthorController::class, '_handler_method' => 'index']
            ],
            [
                '/authors/{id}',
                ['GET'],
                ['_handler_class' => AuthorController::class, '_handler_method' => 'get']
            ],
            [
                '/authors',
                ['POST'],
                ['_handler_class' => AuthorController::class, '_handler_method' => 'post']
            ],
            [
                '/authors/{id}',
                ['PUT'],
                ['_handler_class' => AuthorController::class, '_handler_method' => 'put']
            ],
            [
                '/authors/{id}',
                ['PATCH'],
                ['_handler_class' => AuthorController::class, '_handler_method' => 'patch']
            ],
            [
                '/authors/{id}',
                ['DELETE'],
                ['_handler_class' => AuthorController::class, '_handler_method' => 'delete']
            ],
            // blog
            [
                '/blogs',
                ['GET'],
                ['_handler_class' => BlogController::class, '_handler_method' => 'index']
            ],
            [
                '/blogs/{id}',
                ['GET'],
                ['_handler_class' => BlogController::class, '_handler_method' => 'get']
            ],
            [
                '/blogs',
                ['POST'],
                ['_handler_class' => BlogController::class, '_handler_method' => 'post']
            ],
            [
                '/blogs/{id}',
                ['PUT'],
                ['_handler_class' => BlogController::class, '_handler_method' => 'put']
            ],
            [
                '/blogs/{id}',
                ['PATCH'],
                ['_handler_class' => BlogController::class, '_handler_method' => 'patch']
            ],
            [
                '/blogs/{id}',
                ['DELETE'],
                ['_handler_class' => BlogController::class, '_handler_method' => 'delete']
            ],
        ];

        return [
            [$expects]
        ];
    }
}
