<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use K9u\RequestMapper\Annotation\AbstractMapping;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection as HandlerCollection;

/**
 * @internal
 */
final class HandlerCollector
{
    private const ANNOTATION_CLASS = AbstractMapping::class;

    private string $handlerDir;

    private LoaderInterface $loader;

    public function __construct(string $handlerDir)
    {
        assert(is_dir($handlerDir));

        $this->handlerDir = $handlerDir;
        $this->loader = self::createAnnotatedHandlerLoader(self::ANNOTATION_CLASS);
    }

    public function __invoke(): HandlerCollection
    {
        return $this->loader->load($this->handlerDir);
    }

    /**
     * @SuppressWarnings(PHPMD.UndefinedVariables)
     * FIXME: upgrade PHPMD if v2.9 will be released.
     *        this warning is false. (the bug of PHPMD v2.8.)
     *        https://github.com/phpmd/phpmd/issues/718
     */
    private static function createAnnotatedHandlerLoader(string $annotationClass): LoaderInterface
    {
        assert(class_exists($annotationClass));

        $annotationReader = new SimpleAnnotationReader();
        $annotationReader->addNamespace((new ReflectionClass($annotationClass))->getNamespaceName());

        $classLoader = new class ($annotationReader) extends AnnotationClassLoader
        {
            /**
             * @param Route                   $route
             * @param ReflectionClass<object> $class
             * @param ReflectionMethod        $method
             * @param object                  $annotation
             *
             * @return void
             */
            protected function configureRoute(
                Route $route,
                ReflectionClass $class,
                ReflectionMethod $method,
                $annotation
            ) {
                unset($annotation); // unused

                $route->addDefaults([
                    '_handler_class' => $class->getName(),
                    '_handler_method' => $method->getName()
                ]);
            }
        };

        $classLoader->setRouteAnnotationClass($annotationClass);

        return new AnnotationDirectoryLoader(new FileLocator(), $classLoader);
    }
}
