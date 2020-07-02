<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use Psr\Http\Message\ServerRequestInterface;

interface HandlerInvokerInterface
{
    /**
     * Invoke handler
     *
     * @param Handler                $handler handler
     * @param ServerRequestInterface $request request
     *
     * @return mixed return value of the invoked handler
     */
    public function __invoke(Handler $handler, ServerRequestInterface $request);
}
