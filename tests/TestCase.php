<?php

namespace Tests;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->admin()->create();

        $this->actingAs($this->user);

        Country::create([
            'name' => 'Brasil',
            'acronym' => 'BR',
        ]);

        State::create([
            'name' => 'Rio de Janeiro',
            'acronym' => 'RJ',
            'country_id' => 1,
        ]);

        City::create([
            'name' => 'Rio de Janeiro',
            'ibge_code' => 3304557,
            'state_id' => 1,
        ]);
    }
}
