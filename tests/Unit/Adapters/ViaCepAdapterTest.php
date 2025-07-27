<?php

namespace Tests\Unit\Adapters;

use App\Adapters\ViaCepAdapter;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;

class ViaCepAdapterTest extends TestCase
{
    private ViaCepAdapter $adapter;

    private Client $client;

    private ResponseInterface $response;

    private StreamInterface $stream;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->createMock(Client::class);
        $this->response = $this->createMock(ResponseInterface::class);
        $this->stream = $this->createMock(StreamInterface::class);

        $this->adapter = new ViaCepAdapter($this->client);
    }

    public function testAddressSuccess(): void
    {
        $zipCode = '01001000';

        $responseContent = json_encode([
            'cep' => $zipCode,
            'logradouro' => 'Praça da Sé',
            'complemento' => 'lado ímpar',
            'bairro' => 'Sé',
            'localidade' => 'São Paulo',
            'uf' => 'SP',
            'ibge' => '3550308',
            'gia' => '1004',
            'ddd' => '11',
            'siafi' => '7107',
        ]);

        $expected = json_decode($responseContent, true);

        $this->client->expects($this->once())
            ->method('get')
            ->with("{$zipCode}/json/")
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(200);

        $this->response->expects($this->once())
            ->method('getBody')
            ->willReturn($this->stream);

        $this->stream->expects($this->once())
            ->method('getContents')
            ->willReturn($responseContent);

        $result = $this->adapter->address($zipCode);

        $this->assertEquals($expected, $result);
    }

    public function testAddressError(): void
    {
        $zipCode = '01001000';

        $this->client->expects($this->once())
            ->method('get')
            ->with("{$zipCode}/json/")
            ->willReturn($this->response);

        $this->response->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(404);

        $result = $this->adapter->address($zipCode);

        $this->assertEquals(['error' => true], $result);
    }

    public function testAddressException(): void
    {
        $zipCode = '01001000';

        $this->client->expects($this->once())
            ->method('get')
            ->with("{$zipCode}/json/")
            ->willThrowException(new \Exception());

        $result = $this->adapter->address($zipCode);

        $this->assertEquals(['error' => true], $result);
    }
}
