<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class PostCsrfGuardMiddleware implements MiddlewareInterface
{
    public function __construct()
    {
    }

    public function process(ServerRequest $request, RequestHandler $handler): Response
    {
        return $handler->handle($request);
    }
}
