<?php

namespace App\Http\Controllers;

use App\Facades\ViaCepFacade;
use App\Http\Requests\GetAddressByZipCodeRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAddressByZipCode extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetAddressByZipCodeRequest $request)
    {
        $viacepResponse = ViaCepFacade::address($request->zip_code);
        if (isset($viacepResponse['error']) && $viacepResponse['error'] === true) {
            return response()->json(['message' => "Falha ao realizar a busca do CEP: $request->zip_code"], Response::HTTP_BAD_REQUEST);
        }

        $city = City::query()->where('ibge_code', $viacepResponse['ibge'])->first();
        if (!$city) {
            return response()->json(['message' => "Cidade não encontrada para o CEP: $request->zip_code"], Response::HTTP_BAD_REQUEST);
        }

        $state = State::query()->find($city->state_id);
        if (!$state) {
            return response()->json(['message' => "Estado não encontrado para o CEP: $request->zip_code"], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'city' => $city->name,
            'city_id' => $city->id,
            'state' => "$state->name ($state->acronym)",
            'street' => $viacepResponse['logradouro'],
            'district' => $viacepResponse['bairro'],
            'complement' => $viacepResponse['complemento'],
        ]);
    }
}
