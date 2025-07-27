<?php

namespace Tests\Feature\Http\Controllers;

use App\Facades\ViaCepFacade;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GetAddressByZipCodeControllerTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testSuccess(array $viaCepResponse, int $statusCode, array $expected): void
    {
        ViaCepFacade::shouldReceive('address')->once()->andReturn($viaCepResponse);

        $this->getJson(route('getAddressByZipCode', '01001000'))
            ->assertStatus($statusCode)
            ->assertJson($expected);
    }

    public static function dataProvider(): array
    {
        return [
            'Success' => [
                'viaCepResponse' => [
                    'ibge' => '3304557',
                    'logradouro' => 'Praça da Sé',
                    'bairro' => 'Sé',
                    'complemento' => 'lado ímpar',
                ],
                'statusCode' => Response::HTTP_OK,
                'expected' => [
                    'city' => 'Rio de Janeiro',
                    'city_id' => 1,
                    'state' => 'Rio de Janeiro (RJ)',
                    'street' => 'Praça da Sé',
                    'district' => 'Sé',
                    'complement' => 'lado ímpar',
                ]
            ],
            'Via CEP Error' => [
                'viaCepResponse' => [
                    'error' => true,
                ],
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'expected' => [
                    'message' => 'Falha ao realizar a busca do CEP: 01001000',
                ]
            ],
            'City not found error' => [
                'viaCepResponse' => [
                    'ibge' => '3304558',
                ],
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'expected' => [
                    'message' => 'Cidade não encontrada para o CEP: 01001000',
                ]
            ],
        ];
    }
}
