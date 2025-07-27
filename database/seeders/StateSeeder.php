<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statesFileContent = file_get_contents(base_path('database/data/states.json'));
        $states = json_decode($statesFileContent, true);
        $country = Country::query()->where('acronym', 'BR')->firstOrFail();

        foreach ($states as $state) {
            State::create([
                'country_id' => $country->id,
                'name' => $state['nome'],
                'acronym' => $state['sigla'],
            ]);
        }
    }
}
