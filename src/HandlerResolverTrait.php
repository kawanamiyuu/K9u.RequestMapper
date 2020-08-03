<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException as MethodNotAllowed;
use Symfony\Component\Routing\Exception\ResourceNotFoundException as HandlerNotFound;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * @internal
 */
trait HandlerResolverTrait
{
    private function createRequestContext(ServerRequestInterface $request): RequestContext
    {
        return new RequestContext($request->getUri()->getPath(), $request->getMethod());
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
