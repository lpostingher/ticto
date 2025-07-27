<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testIndex(): void
    {
        User::factory()->employee()->create(['name' => 'User A', 'email' => 'userA@example.com']);
        User::factory()->employee()->create(['name' => 'User B', 'email' => 'userB@example.com']);

        $this->get(route('users.index'))
            ->assertOk()
            ->assertSeeInOrder(['User A', 'userA@example.com', 'User B', 'userB@example.com']);

        $this->get(route('users.index', ['search' => 'User A']))
            ->assertOk()
            ->assertSeeInOrder(['User A', 'userA@example.com']);

        $this->get(route('users.index', ['search' => 'userA']))
            ->assertOk()
            ->assertSeeInOrder(['User A', 'userA@example.com']);

        $this->get(route('users.index', ['search' => 'User B']))
            ->assertOk()
            ->assertSeeInOrder(['User B', 'userB@example.com']);

        $this->get(route('users.index', ['search' => 'userB']))
            ->assertOk()
            ->assertSeeInOrder(['User B', 'userB@example.com']);
    }

    public function testCreate(): void
    {
        $this->get(route('users.create'))
            ->assertOk()
            ->assertViewHas('pageTitle', 'Novo usuário')
            ->assertViewHas('action', route('users.store'))
            ->assertViewHas('method', 'POST')
            ->assertViewHas('roles', UserRoleEnum::asSelectArray());
    }

    public function testStore(): void
    {
        $payload = $this->getDefaultUserData();

        $this->post(route('users.store'), $payload)
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status', ['class' => 'success', 'message' => 'Usuário criado com sucesso!']);

        $this->assertDatabaseHas('users', [
            'name' => 'User A',
            'email' => 'userA@example.com',
            'role' => UserRoleEnum::EMPLOYEE,
        ]);
    }

    public function testStoreValidateRequiredFields(): void
    {
        $this->post(route('users.store'), [])
            ->assertSessionHasErrors([
                'name' => 'The name field is required.',
                'email' => 'The email field is required.',
                'password' => 'The password field is required.',
                'role' => 'The role field is required.',
                'taxvat_number' => 'The taxvat number field is required.',
                'birth_date' => 'The birth date field is required.',
                'zip_code' => 'The zip code field is required.',
                'street' => 'The street field is required.',
                'number' => 'The number field is required.',
                'city_id' => 'The city id field is required.',
                'district' => 'The district field is required.',
            ]);
    }

    public function testStoreValidateTaxvatNumber(): void
    {
        $this->post(route('users.store'), ['taxvat_number' => '12345678901'])
            ->assertSessionHasErrors('taxvat_number');

        $this->post(route('users.store'), ['taxvat_number' => '03289402088'])
            ->assertSessionDoesntHaveErrors('taxvat_number');
    }

    public function testStoreValidateEmail(): void
    {
        $user = $this->getDefaultUser();

        $this->post(route('users.store'), [])
            ->assertSessionHasErrors('email');

        $this->post(route('users.store'), ['email' => 'userB@example.com'])
            ->assertSessionDoesntHaveErrors('email');

        $this->post(route('users.store'), ['email' => $user->email])
            ->assertSessionHasErrors('email');
    }

    public function testStoreValidateRole(): void
    {
        $this->post(route('users.store'), ['role' => 'invalid'])
            ->assertSessionHasErrors('role');

        $this->post(route('users.store'), ['role' => UserRoleEnum::EMPLOYEE])
            ->assertSessionDoesntHaveErrors('role');
    }

    public function testStoreValidateBirthDate(): void
    {
        $this->post(route('users.store'), ['birth_date' => 'invalid'])
            ->assertSessionHasErrors('birth_date');

        $this->post(route('users.store'), ['birth_date' => '1990-01-01'])
            ->assertSessionDoesntHaveErrors('birth_date');

        $this->post(route('users.store'), ['birth_date' => Carbon::now()->addDay()->format('Y-m-d')])
            ->assertSessionHasErrors('birth_date');
    }

    public function testStoreValidateCityId(): void
    {
        $this->post(route('users.store'), ['city_id' => 'invalid'])
            ->assertSessionHasErrors('city_id');

        $this->post(route('users.store'), ['city_id' => 1])
            ->assertSessionDoesntHaveErrors('city_id');

        $this->post(route('users.store'), ['city_id' => 999])
            ->assertSessionHasErrors('city_id');
    }

    public function testStorePassword(): void
    {
        $payload = [
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->post(route('users.store'), $payload)
            ->assertSessionDoesntHaveErrors('password');

        $this->post(route('users.store'), ['password' => '123456'])
            ->assertSessionHasErrors('password');

        $this->post(route('users.store'), ['password' => '87654321', 'password_confirmation' => '12345678'])
            ->assertSessionHasErrors('password');

        $this->post(route('users.store'), ['password' => '123456', 'password_confirmation' => '123456'])
            ->assertSessionHasErrors('password');
    }

    public function testEdit(): void
    {
        $city = City::find(1);
        $state = State::find(1);
        $user = $this->getDefaultUser();

        $this->get(route('users.edit', $user))
            ->assertStatus(200)
            ->assertViewIs('users.form')
            ->assertViewHas('pageTitle', 'Editar usuário')
            ->assertViewHas('user', $user)
            ->assertViewHas('action', route('users.update', $user))
            ->assertViewHas('method', 'PUT')
            ->assertViewHas('roles', UserRoleEnum::asSelectArray())
            ->assertViewHas('city', $city->name)
            ->assertViewHas('state', "$state->name ($state->acronym)");
    }

    public function testUpdate(): void
    {
        $user = $this->getDefaultUser();
        $data = $user->toArray();
        $data['role'] = UserRoleEnum::ADMIN;

        $this->put(route('users.update', $user), $data)
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status', ['class' => 'success', 'message' => 'Usuário atualizado com sucesso!']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => UserRoleEnum::ADMIN
        ]);
    }

    public function testDestroy(): void
    {
        $user = $this->getDefaultUser();

        $this->delete(route('users.destroy', $user))
            ->assertRedirect(route('users.index'))
            ->assertSessionHas('status', ['class' => 'success', 'message' => 'Usuário removido com sucesso!']);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function testShouldBeAdmin(): void
    {
        $user = $this->getDefaultUser();

        $this->actingAs($user)
            ->get(route('users.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    private function getDefaultUser(): User
    {
        $data = $this->getDefaultUserData();
        unset($data['password_confirmation']);

        return User::factory()->create($data);
    }

    private function getDefaultUserData(): array
    {
        return [
            'name' => 'User A',
            'email' => 'userA@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => UserRoleEnum::EMPLOYEE,
            'taxvat_number' => '03289402088',
            'birth_date' => '1990-01-01',
            'zip_code' => '12345678',
            'street' => 'Rua A',
            'number' => '123',
            'city_id' => 1,
            'district' => 'Bairro A',
        ];
    }
}
