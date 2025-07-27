<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\TimeEntryTypeEnum;
use Carbon\Carbon;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSeeText('REGISTRAR ENTRADA')
            ->assertSeeHtml("<span>Último registro:</span>");
    }

    public function testIndexOut(): void
    {
        $this->user->update([
            'last_time_entry_type' => TimeEntryTypeEnum::IN,
            'last_time_entry_timestamp' => Carbon::now()->subMinutes(30),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeText('REGISTRAR SAÍDA')
            ->assertSeeHtml("<span>Último registro:</span>")
            ->assertSeeHtml("<span>{$this->user->last_time_entry_timestamp->format('d/m/Y H:i:s')}</span>")
            ->assertSeeHtml("<span>ENTRADA</span>");
    }

    public function testIndexIn(): void
    {
        $this->user->update([
            'last_time_entry_type' => TimeEntryTypeEnum::OUT,
            'last_time_entry_timestamp' => Carbon::now()->subMinutes(30),
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeText('REGISTRAR ENTRADA')
            ->assertSeeHtml("<span>Último registro:</span>")
            ->assertSeeHtml("<span>{$this->user->last_time_entry_timestamp->format('d/m/Y H:i:s')}</span>")
            ->assertSeeHtml("<span>SAÍDA</span>");
    }
}
