<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use K9u\RequestMapper\Annotation\AbstractMapping;
use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use Psr\Http\Message\ServerRequestInterface;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\MethodNotAllowedException as MethodNotAllowed;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as HandlerNotFound;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection as HandlerCollection;

/**
 * @internal
 */
trait HandlerResolverTrait
{
    private function createRequestContext(ServerRequestInterface $request): RequestContext
    {
        return new RequestContext($request->getUri()->getPath(), $request->getMethod());
    }

    /**
     * @SuppressWarnings(PHPMD.UndefinedVariables)
     * FIXME: upgrade PHPMD if v2.9 will be released.
     *        this warning is false. (the bug of PHPMD v2.8.)
     *        https://github.com/phpmd/phpmd/issues/718
     */
    private static function collect(string $handlerDir): HandlerCollection
    {
        assert(is_dir($handlerDir));

        $classLoader = new class (AbstractMapping::class) extends AnnotationClassLoader
        {
            public function __construct(string $annotationClass)
            {
                assert(class_exists($annotationClass));
                $this->routeAnnotationClass = $annotationClass;

                $annotationReader = new SimpleAnnotationReader();
                $annotationReader->addNamespace((new ReflectionClass($annotationClass))->getNamespaceName());
                parent::__construct($annotationReader);
            }

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

        $directoryLoader = new AnnotationDirectoryLoader(new FileLocator(), $classLoader);

        return $directoryLoader->load($handlerDir);
    }

    private function resolve(ServerRequestInterface $request, UrlMatcherInterface $matcher): Handler
    {
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();

        try {
            $matched = $matcher->match($path);
        } catch (HandlerNotFound $e) {
            throw new HandlerNotFoundException($method, $path, $e);
        } catch (MethodNotAllowed $e) {
            throw new MethodNotAllowedException($method, $path, $e);
        }

        $pathParams = array_filter($matched, function ($key) {
            return substr($key, 0, 1) !== '_';
        }, ARRAY_FILTER_USE_KEY);

        return new Handler(
            $matched['_handler_class'],
            $matched['_handler_method'],
            $pathParams
        );
    }
}
