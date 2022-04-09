<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use function strtolower;

class HttpsRedirectMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ResponseFactory $response_factory
    ) {
    }

    public function process(ServerRequest $request, RequestHandler $handler): Response
    {
        $uri = $request->getUri();
        if (strtolower($uri->getScheme()) !== 'https') {
            return $this->response_factory->createResponse(302)
                ->withHeader('Location', [(string)$uri->withScheme('https')]);
        }

        return $handler->handle($request);
    }
}
