<?php

namespace App\Observers;

use App\Models\TimeEntry;
use App\Models\User;

class TimeEntryObserver
{
    /**
     * Handle the TimeEntry "created" event.
     */
    public function created(TimeEntry $timeEntry): void
    {
        User::query()
            ->where('id', $timeEntry->user_id)
            ->update([
                'last_time_entry_type' => $timeEntry->type,
                'last_time_entry_timestamp' => $timeEntry->timestamp
            ]);
    }
}
