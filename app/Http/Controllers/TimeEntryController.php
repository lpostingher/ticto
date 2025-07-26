<?php

namespace App\Http\Controllers;

use App\Enums\TimeEntryTypeEnum;
use App\Models\TimeEntry;
use Illuminate\Http\Request;

class TimeEntryController extends Controller
{
    public function store()
    {
        TimeEntry::create([
            'user_id' => auth()->user()->id,
            'timestamp' => now(),
            'type' => auth()->user()->last_time_entry_type == TimeEntryTypeEnum::IN ?
                TimeEntryTypeEnum::OUT : TimeEntryTypeEnum::IN
        ]);

        return redirect()->route('home')
            ->with('status', ['class' => 'success', 'message' => 'Registro realizado com sucesso!']);
    }
}
