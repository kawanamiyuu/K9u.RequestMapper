<?php

declare(strict_types=1);

namespace K9u\Router;

use Doctrine\Common\Annotations\AnnotationReader;
use LogicException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\RouteCollection;

final class OnDemandRouteCollector implements RouteCollectorInterface
{
    /**
     * @var string
     */
    private $baseDir;

    /**
     * @var LoaderInterface
     */
    private $directoryLoader;

    public function __construct(string $baseDir)
    {
        if (! is_dir($baseDir)) {
            throw new LogicException("''{$baseDir}' is not a directory.");
        }

        $this->baseDir = $baseDir;

        $this->directoryLoader = new AnnotationDirectoryLoader(
            new FileLocator(),
            new HandlerClassLoader(new AnnotationReader())
        );
    }

    public function __invoke(): RouteCollection
    {
        return $this->directoryLoader->load($this->baseDir);
    }
}
