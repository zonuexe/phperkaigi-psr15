<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15\Helper;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

// Copyright 2022, USAMI Kenta <tadsan@pixiv.com>
//
// Copying and distribution of this file, with or without modification,
// are permitted in any medium without royalty provided the copyright
// notice and this notice are preserved.  This file is offered as-is,
// without any warranty.

trait HttpFactoryTrait
{
    public function getRequestFactory(): RequestFactoryInterface
    {
        return $this->psr17factory();
    }

    public function getResponseFactory(): ResponseFactoryInterface
    {
        return $this->psr17factory();
    }

    public function getServerRequestFactory(): ServerRequestFactoryInterface
    {
        return $this->psr17factory();
    }

    public function getStreamFactory(): StreamFactoryInterface
    {
        return $this->psr17factory();
    }

    public function getUriFactory(): UriFactoryInterface
    {
        return $this->psr17factory();
    }

    /**
     * Create a new stream from a string.
     *
     * The stream SHOULD be created with a temporary resource.
     *
     * @param string $content String content with which to populate the stream.
     */
    public function createStream(string $contents): StreamInterface
    {
        return $this->getStreamFactory()->createStream($contents);
    }

    /**
     * Create a stream from an existing file.
     *
     * The file MUST be opened using the given mode, which may be any mode
     * supported by the `fopen` function.
     *
     * The `$filename` MAY be any string supported by `fopen()`.
     *
     * @param string $filename The filename or stream URI to use as basis of stream.
     * @param string $mode The mode with which to open the underlying filename/stream.
     *
     * @throws \RuntimeException If the file cannot be opened.
     * @throws \InvalidArgumentException If the mode is invalid.
     */
    public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
    {
        return $this->getStreamFactory()->createStreamFromFile($filename, $mode);
    }

    /**
     * Create a new response.
     *
     * @param int $code The HTTP status code. Defaults to 200.
     * @param string $reasonPhrase The reason phrase to associate with the status code
     *     in the generated response. If none is provided, implementations MAY use
     *     the defaults as suggested in the HTTP specification.
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        return $this->getResponseFactory()->createResponse($code, $reasonPhrase);
    }

    /**
     * Create a new server request.
     *
     * Note that server parameters are taken precisely as given - no parsing/processing
     * of the given values is performed. In particular, no attempt is made to
     * determine the HTTP method or URI, which must be provided explicitly.
     *
     * @param string $method The HTTP method associated with the request.
     * @param UriInterface|string $uri The URI associated with the request.
     * @param array $serverParams An array of Server API (SAPI) parameters with
     *     which to seed the generated request instance.
     * @phpstan-param array<string,string|array> $serverParams
     */
    public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
    {
        return $this->getServerRequestFactory()->createServerRequest($method, $uri, $serverParams);
    }

    private function psr17factory(): Psr17Factory
    {
        return new Psr17Factory();
    }
}
