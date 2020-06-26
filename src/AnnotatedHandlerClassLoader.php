<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Route;

class AnnotatedHandlerClassLoader extends AnnotationClassLoader
{
    private const HANDLER_CLASS_KEY = '_handler_class';

    private const HANDLER_METHOD_KEY = '_handler_method';

    public function __construct(string $annotationClass)
    {
        parent::__construct(new AnnotationReader());

        $this->setRouteAnnotationClass($annotationClass);
    }

    /**
     * @param Route                   $route
     * @param ReflectionClass<object> $class
     * @param ReflectionMethod        $method
     * @param object                  $annotation
     *
     * @return void
     */
    protected function configureRoute(Route $route, ReflectionClass $class, ReflectionMethod $method, $annotation)
    {
        unset($annotation); // unused

        $route->setDefaults([
            self::HANDLER_CLASS_KEY => $class->getName(),
            self::HANDLER_METHOD_KEY => $method->getName()
        ]);
    }

    /**
     * @param array<string, string> $params
     *
     * @return string
     */
    public static function extractHandlerClass(array $params): string
    {
        return $params[self::HANDLER_CLASS_KEY];
    }

    /**
     * @param array<string, string> $params
     *
     * @return string
     */
    public static function extractHandlerMethod(array $params): string
    {
        return $params[self::HANDLER_METHOD_KEY];
    }

    /**
     * @param array<string, string> $params
     *
     * @return array<string, string>
     */
    public static function extractPathVariables(array $params): array
    {
        return array_filter($params, function ($key) {
            return substr($key, 0, 1) !== '_';
        }, ARRAY_FILTER_USE_KEY);
    }
}
