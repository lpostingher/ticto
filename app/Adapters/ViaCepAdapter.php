<?php

namespace App\Adapters;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ViaCepAdapter extends BaseAdapter
{
    public function address(string $cep): array
    {
        try {
            $response = $this->client->get("{$cep}/json/");
            if ($response->getStatusCode() !== 200) {
                return ['error' => true];
            }

            return (array) json_decode($response->getBody()->getContents());
        } catch (\Exception | GuzzleException $e) {
            Log::error($e->getMessage());

            return ['error' => true];
        }
    }
}
