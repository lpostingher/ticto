<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citiesFileContent = file_get_contents(base_path('database/data/cities.json'));
        $cities = json_decode($citiesFileContent, true);

        State::all()->each(function ($state) use ($cities) {
            $filteredCities = array_filter($cities, function ($value) use ($state) {
                return isset($value['microrregiao']) && $state->acronym == $value['microrregiao']['mesorregiao']['UF']['sigla'];
            });

            foreach ($filteredCities as $city) {
                City::create([
                    'state_id' => $state->id,
                    'name' => $city['nome'],
                    'ibge_code' => $city['id']
                ]);
            }
        });
    }
}
