<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\TimeEntryTypeEnum;
use App\Enums\UserRoleEnum;
use App\Models\TimeEntry;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TimeEntryControllerTest extends TestCase
{
    private User $userA;
    private User $userB;
    private User $userC;

    public function setUp(): void
    {
        parent::setUp();

        $this->userA = User::factory()->employee()->create();
        TimeEntry::create([
            'user_id' => $this->userA->id,
            'type' => TimeEntryTypeEnum::IN,
            'timestamp' => Carbon::now()->subMinutes(40)
        ]);
        TimeEntry::create([
            'user_id' => $this->userA->id,
            'type' => TimeEntryTypeEnum::OUT,
            'timestamp' => Carbon::now()->subMinutes(30)
        ]);

        $this->userB = User::factory()->employee()->create();
        TimeEntry::create([
            'user_id' => $this->userB->id,
            'type' => TimeEntryTypeEnum::IN,
            'timestamp' => Carbon::now()->subMinutes(20)
        ]);
        TimeEntry::create([
            'user_id' => $this->userB->id,
            'type' => TimeEntryTypeEnum::OUT,
            'timestamp' => Carbon::now()->subMinutes(10)
        ]);

        $this->userC = User::factory()->admin()->create();
        TimeEntry::create([
            'user_id' => $this->userC->id,
            'type' => TimeEntryTypeEnum::IN,
            'timestamp' => Carbon::now()->subMinutes(60)
        ]);
        TimeEntry::create([
            'user_id' => $this->userC->id,
            'type' => TimeEntryTypeEnum::OUT,
            'timestamp' => Carbon::now()->subMinutes(50)
        ]);
    }

    public function testIndex(): void
    {
        $this->get(route('timeEntries.index'))
            ->assertOk()
            ->assertViewHas('timeEntries')
            ->assertViewHas('users')
            ->assertViewHas('timeEntryTypes', TimeEntryTypeEnum::asSelectArray())
            ->assertViewHas('roles', UserRoleEnum::asSelectArray());
    }

    public function testIndexUserFilter(): void
    {
        $this->get(route('timeEntries.index', ['user_id' => $this->userA->id]))
            ->assertOk()
            ->assertSeeHtml("<td>{$this->userA->name}</td>")
            ->assertDontSeeHtml("<td>{$this->userB->name}</td>");
    }

    public function testIndexRoleFilter(): void
    {
        $this->get(route('timeEntries.index', ['role' => UserRoleEnum::EMPLOYEE]))
            ->assertOk()
            ->assertSeeHtml("<td>{$this->userA->name}</td>")
            ->assertSeeHtml("<td>{$this->userB->name}</td>")
            ->assertDontSeeHtml("<td>{$this->userC->name}</td>");

        $this->get(route('timeEntries.index', ['role' => UserRoleEnum::ADMIN]))
            ->assertOk()
            ->assertDontSeeHtml("<td>{$this->userA->name}</td>")
            ->assertDontSeeHtml("<td>{$this->userB->name}</td>")
            ->assertSeeHtml("<td>{$this->userC->name}</td>");
    }

    public function testIndexTimeEntryTypeFilter(): void
    {
        $this->get(route('timeEntries.index', ['time_entry_type' => TimeEntryTypeEnum::IN]))
            ->assertOk()
            ->assertSeeHtml("<td>Entrada</td>")
            ->assertDontSeeHtml("<td>Saída</td>");

        $this->get(route('timeEntries.index', ['time_entry_type' => TimeEntryTypeEnum::OUT]))
            ->assertOk()
            ->assertSeeHtml("<td>Saída</td>")
            ->assertDontSeeHtml("<td>Entrada</td>");
    }

    public function testIndexTimestampFilter(): void
    {
        $user = User::factory()->admin()->create();
        TimeEntry::create([
            'user_id' => $user->id,
            'type' => TimeEntryTypeEnum::IN,
            'timestamp' => Carbon::now()->subDays(2)
        ]);
        TimeEntry::create([
            'user_id' => $user->id,
            'type' => TimeEntryTypeEnum::OUT,
            'timestamp' => Carbon::now()->subDays(2)
        ]);

        $this->get(route('timeEntries.index', []))
            ->assertOk()
            ->assertSeeHtml("<td>{$this->userA->name}</td>")
            ->assertSeeHtml("<td>{$this->userB->name}</td>")
            ->assertSeeHtml("<td>{$this->userC->name}</td>")
            ->assertDontSeeHtml("<td>{$user->name}</td>");

        $initialDate = Carbon::now()->subDays(2)->startOfDay()->format('d/m/Y H:i:s');
        $finalDate = Carbon::now()->subDays(2)->endOfDay()->format('d/m/Y H:i:s');

        $this->get(route('timeEntries.index', [
            'timestamp' => $initialDate . ' - ' . $finalDate,
        ]))
            ->assertOk()
            ->assertSeeHtml("<td>{$user->name}</td>")
            ->assertDontSeeHtml("<td>{$this->userA->name}</td>")
            ->assertDontSeeHtml("<td>{$this->userB->name}</td>")
            ->assertDontSeeHtml("<td>{$this->userC->name}</td>");
    }

    public function testStore(): void
    {
        $user = User::factory()->employee()->create([
            'last_time_entry_type' => TimeEntryTypeEnum::IN,
            'last_time_entry_timestamp' => Carbon::now()->subMinutes(30),
        ]);

        $this->actingAs($user)
            ->post(route('timeEntries.store'))
            ->assertRedirect(route('home'))
            ->assertSessionHas('status', ['class' => 'success', 'message' => 'Registro realizado com sucesso!']);

        $this->assertDatabaseHas('time_entries', [
            'user_id' => $user->id,
            'type' => TimeEntryTypeEnum::OUT,
        ]);
    }

    public function testShouldBeAdmin(): void
    {
        $user = User::factory()->employee()->create();

        $this->actingAs($user)
            ->get(route('timeEntries.index'))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
}
