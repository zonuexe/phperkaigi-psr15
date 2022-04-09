<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use function Safe\json_encode;

class SecureResponseHeadersMiddleware implements MiddlewareInterface
{
    public function process(ServerRequest $request, RequestHandler $handler): Response
    {
        return $handler->handle($request)
            ->withHeader('X-Content-Type-Options', ['nosniff']);
    }
}
