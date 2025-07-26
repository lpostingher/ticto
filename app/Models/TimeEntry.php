<?php

namespace App\Models;

use App\Observers\TimeEntryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(TimeEntryObserver::class)]
class TimeEntry extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
