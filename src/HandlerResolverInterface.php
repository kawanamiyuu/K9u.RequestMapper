<?php

declare(strict_types=1);

namespace K9u\RequestMapper;

use K9u\RequestMapper\Exception\HandlerNotFoundException;
use K9u\RequestMapper\Exception\MethodNotAllowedException;
use Psr\Http\Message\ServerRequestInterface;

interface HandlerResolverInterface
{
    /**
     * Resolve the handler mapped to the given request
     *
     * @param ServerRequestInterface $request
     *
     * @return Handler
     *
     * @throws HandlerNotFoundException if the handler is not be found
     * @throws MethodNotAllowedException if the handler is found but the request method is not allowed
     */
    public function __invoke(ServerRequestInterface $request): Handler;
}
