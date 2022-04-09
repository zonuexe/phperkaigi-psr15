<?php

declare(strict_types=1);

namespace zonuexe\PHPerKaigi\Psr15;

use Psr\Http\Message\ServerRequestInterface as ServerRequest;

class HelloJsonHandlerTest extends TestCase
{
    use Helper\HttpFactoryTrait;

    private HelloJsonHandler $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new HelloJsonHandler($this->psr17factory(), $this->psr17factory());
    }

    /**
     * @dataProvider requestProvider
     * @param array{status_code:positive-int,headers:array<string,non-empty-list<string>>,body:string} $expected
     */
    public function test(ServerRequest $request, array $expected): void
    {
        $actual = $this->subject->handle($request);

        $this->assertSame($expected['status_code'], $actual->getStatusCode());
        $this->assertEquals($expected['headers'], $actual->getHeaders());
        $this->assertSame($expected['body'], (string)$actual->getBody());
    }

    /**
     * @return iterable<array{ServerRequest, array{status_code:positive-int,headers:array<string,non-empty-list<string>>,body:string}}>
     */
    public function requestProvider(): iterable
    {
        yield 'GET' => [
            $this->createServerRequest('GET', '/dummy'),
            [
                'status_code' => 200,
                'headers' => [
                    'Content-Type' => ['application/json'],
                ],
                'body' => '{"Hello":"World"}',
            ],
        ];

        $default_expected = [
            'status_code' => 404,
            'headers' => [],
            'body' => '',
        ];

        $http_methods = ['POST', 'PUT', 'DELETE'];

        foreach ($http_methods as $method) {
            yield $method => [
                $this->createServerRequest($method, '/dummy'),
                $default_expected,
            ];
        }
    }
}
