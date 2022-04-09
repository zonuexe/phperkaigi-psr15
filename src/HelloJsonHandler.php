<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Psr\Http\Message\StreamFactoryInterface as StreamFactory;
use Psr\Http\Server\RequestHandlerInterface;
use function Safe\json_encode;

class HelloJsonHandler implements RequestHandlerInterface
{
    public function __construct(
        private StreamFactory $stream_factory,
        private ResponseFactory $response_factory
    ) {
    }

    public function handle(ServerRequest $request): Response
    {
        if ($request->getMethod() !== 'GET') {
            return $this->response_factory->createResponse(404);
        }

        $body = $this->stream_factory->createStream(json_encode(['Hello' => 'World']));

        return $this->response_factory->createResponse(200)
            ->withHeader('Content-Type', ['application/json'])
            ->withBody($body);
    }
}
