<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15;

use Psr\Http\Message\ServerRequestInterface as ServerRequest;
use zonuexe\PHPerKaigi\Psr15\Helper\RawHandler;

class HttpsRedirectMiddlewareTest extends TestCase
{
    use Helper\HttpFactoryTrait;

    private HttpsRedirectMiddleware $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new HttpsRedirectMiddleware($this->psr17factory());
    }

    /**
     * @dataProvider requestProvider
     * @param array{status_code:positive-int,headers:array<string,non-empty-list<string>>,not_redirected_count:0|positive-int} $expected
     */
    public function test(ServerRequest $request, array $expected): void
    {
        $ok_handler = new RawHandler($this->createResponse(200));
        $actual = $this->subject->process($request, $ok_handler);

        $this->assertSame($expected['status_code'], $actual->getStatusCode());
        $this->assertEquals($expected['headers'], $actual->getHeaders());
        $this->assertCount($expected['not_redirected_count'], $ok_handler->received_server_requests);
        $this->assertSame('', (string)$actual->getBody());
    }

    /**
     * @return iterable<array{ServerRequest, array{status_code:positive-int,headers:array<string,non-empty-list<string>>,not_redirected_count:0|positive-int}}>
     */
    public function requestProvider(): iterable
    {
        $expected = fn (bool $should_redirected) => match ($should_redirected) {
            true => [
                'status_code' => 302,
                'headers' => [
                    'Location' => ['https://example.com/dummy'],
                ],
                'not_redirected_count' => 0,
            ],
            false => [
                'status_code' => 200,
                'headers' => [],
                'not_redirected_count' => 1,
            ],
        };

        $uri = $this->getUriFactory()->createUri('http://example.com/dummy');
        $request = $this->createServerRequest('GET', '/dummy');

        return [
            'http' => [
                $request->withUri($uri->withScheme('http')),
                $expected(true),
            ],
            'https' => [
                $request->withUri($uri->withScheme('https')),
                $expected(false),
            ],
        ];
    }
}
