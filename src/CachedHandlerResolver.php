<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;

class CachedHandlerResolver implements HandlerResolverInterface
{
    use HandlerResolverTrait;

    /**
     * @var array<mixed>
     *
     * @see \Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper::dump()
     */
    private array $compiledMappings;

    public function __construct(string $cacheDir)
    {
        $cacheFile = rtrim($cacheDir, '/') . '/' . MappingCompiler::MAPPING;
        if (! file_exists($cacheFile)) {
            throw new InvalidArgumentException('cache file does not exist.');
        }

        $cache = require $cacheFile;
        assert(is_array($cache) && count($cache) === 5);

        $this->compiledMappings = $cache;
    }

    public function __invoke(ServerRequestInterface $request): Handler
    {
        $matcher = new CompiledUrlMatcher(
            $this->compiledMappings,
            $this->createRequestContext($request)
        );

        return $this->resolve($request, $matcher);
    }
}
