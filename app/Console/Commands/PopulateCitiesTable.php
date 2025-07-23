<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Console\Command;

class PopulateCitiesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-cities-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate cities table';

    /**
     * Execute the console command.
     */
    public function handle()
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
