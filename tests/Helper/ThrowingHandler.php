<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15\Helper;

use Psr\Http\Message\ResponseFactoryInterface as ResponseFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ThrowingHandler implements RequestHandlerInterface
{
    /**
     * @psalm-var list<ServerRequest>
     * @psalm-readonly-allow-private-mutation
     */
    public $received_server_requests = [];

    public function __construct(private Throwable $e)
    {
    }

    public function handle(ServerRequest $request): Response
    {
        $this->received_server_requests[] = $request;

        throw $this->e;
    }
}
