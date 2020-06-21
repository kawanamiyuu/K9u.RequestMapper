<?php

declare(strict_types=1);

namespace K9u\Router;

use Doctrine\Common\Annotations\AnnotationReader;
use K9u\Router\Annotation\AbstractMapping;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Route;

class HandlerClassLoader extends AnnotationClassLoader
{
    public const HANDLER_CLASS_KEY = '_handler_class';

    public const HANDLER_METHOD_KEY = '_handler_method';

    public function __construct()
    {
        parent::__construct(new AnnotationReader());

        $this->setRouteAnnotationClass(AbstractMapping::class);
    }

    /**
     * @param Route                   $route
     * @param ReflectionClass<object> $class
     * @param ReflectionMethod        $method
     * @param object                  $annotation
     */
    protected function configureRoute(Route $route, ReflectionClass $class, ReflectionMethod $method, $annotation): void
    {
        assert(count($route->getMethods()) === 1);
        assert($annotation instanceof AbstractMapping);

        $route->setDefaults([
            self::HANDLER_CLASS_KEY => $class->getName(),
            self::HANDLER_METHOD_KEY => $method->getName()
        ]);
    }
}