<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use InvalidArgumentException;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;

class MappingCompiler
{
    public const MAPPING = 'mapping.php';

    private string $cacheDir;

    public function __construct(string $cacheDir)
    {
        ! is_dir($cacheDir) && mkdir($cacheDir, 0777, true);
        $this->cacheDir = rtrim($cacheDir, '/');
    }

    public function __invoke(string $handlerDir): void
    {
        if (! is_dir($handlerDir)) {
            throw new InvalidArgumentException('specify root directory that handlers are located.');
        }

        $dumper = new CompiledUrlMatcherDumper((new HandlerCollector($handlerDir))());
        file_put_contents($this->cacheDir . '/' . self::MAPPING, $dumper->dump(), LOCK_EX);
    }
}
