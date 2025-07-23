<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\State;
use Illuminate\Console\Command;

class PopulateStatesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-states-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate states table';

    /**
     * Execute the console command.
     */
    public function handle()
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
