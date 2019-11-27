<?php

declare(strict_types=1);

namespace K9u\Router;

use Doctrine\Common\Annotations\AnnotationReader;
use LogicException;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use K9u\Router\Annotation\AbstractRoute;

final class OnDemandRouteCollector implements RouteCollectorInterface
{
    /**
     * @var string
     */
    private $baseDir;

    public function __construct(string $baseDir)
    {
        if (! is_dir($baseDir)) {
            throw new LogicException("''{$baseDir}' is not a directory.");
        }

        $this->baseDir = $baseDir;
    }

    public function __invoke(): RouteCollection
    {
        $classLoader = new class (new AnnotationReader()) extends AnnotationClassLoader {

            protected function configureRoute(
                Route $route,
                ReflectionClass $class,
                ReflectionMethod $method,
                $annotation
            ) {
                assert($annotation instanceof AbstractRoute);

                $route->setDefaults([
                    '_handler_class' => $class->getName(),
                    '_handler_method' => $method->getName()
                ]);
            }
        };

        $classLoader->setRouteAnnotationClass(AbstractRoute::class);

        $directoryLoader = new AnnotationDirectoryLoader(new FileLocator(), $classLoader);

        return $directoryLoader->load($this->baseDir);
    }
}
