<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countriesFileContent = file_get_contents(base_path('database/data/countries.json'));
        $countries = json_decode($countriesFileContent, true);

        foreach ($countries as $country) {
            Country::create([
                'name' => $country['nome'],
                'acronym' => $country['id']['ISO-ALPHA-2'],
            ]);
        }
    }
}
