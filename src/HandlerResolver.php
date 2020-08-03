<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RouteCollection as HandlerCollection;

class HandlerResolver implements HandlerResolverInterface
{
    use HandlerResolverTrait;

    private string $handlerDir;

    private HandlerCollection $handlerCollection;

    public function __construct(string $handlerDir)
    {
        if (! is_dir($handlerDir)) {
            throw new InvalidArgumentException('specify root directory that handlers are located.');
        }

        $this->handlerDir = $handlerDir;
    }

    public function __invoke(ServerRequestInterface $request): Handler
    {
        if (! isset($this->handlerCollection)) {
            $this->handlerCollection = $this->collect($this->handlerDir);
        }

        $matcher = new UrlMatcher(
            $this->handlerCollection,
            $this->createRequestContext($request)
        );

        return $this->resolve($request, $matcher);
    }
}
