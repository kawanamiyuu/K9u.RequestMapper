<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use PHPUnit\Framework\TestCase;

class MappingCompilerTest extends TestCase
{
    private const CACHE_DIR = __DIR__ . '/cache';

    private const FIXTURE_CACHE_DIR = __DIR__ . '/fixtures/cache';
    private const FIXTURE_HANDLER_DIR = __DIR__ . '/fixtures/handlers';

    public function setUp(): void
    {
        array_map('unlink', glob(self::CACHE_DIR . '/*'));
    }

    public function testInvoke(): void
    {
        $actualCacheFile = self::CACHE_DIR . '/mapping.php';
        $expectedCacheFile = self::FIXTURE_CACHE_DIR . '/mapping.php';

        $compiler = new MappingCompiler(self::CACHE_DIR);
        $compiler(self::FIXTURE_HANDLER_DIR);

        $this->assertFileExists($actualCacheFile);
        $this->assertSame(require $expectedCacheFile, require $actualCacheFile);
    }
}
