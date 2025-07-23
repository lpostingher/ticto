<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;

class PopulateCountriesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-countries-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate countries table';

    /**
     * Execute the console command.
     */
    public function handle()
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
