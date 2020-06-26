<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Annotation\AbstractMapping;
use LogicException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\RouteCollection as HandlerCollection;

final class OnDemandHandlerCollector implements HandlerCollectorInterface
{
    private string $baseDir;

    private LoaderInterface $directoryLoader;

    public function __construct(string $baseDir)
    {
        if (! is_dir($baseDir)) {
            throw new LogicException("''{$baseDir}' is not a directory.");
        }

        $this->baseDir = $baseDir;

        $this->directoryLoader = new AnnotationDirectoryLoader(
            new FileLocator(),
            new AnnotatedHandlerClassLoader(AbstractMapping::class)
        );
    }

    public function __invoke(): HandlerCollection
    {
        return $this->directoryLoader->load($this->baseDir);
    }
}
