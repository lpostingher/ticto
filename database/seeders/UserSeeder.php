<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'taxvat_number' => '88015960061',
            'birth_date' => '1994-10-01',
            'city_id' => 1,
            'zip_code' => '76954000',
            'street' => 'Rua A',
            'number' => '123',
            'district' => 'Bairro A',
        ]);
    }
}
