<?php

namespace App\Http\Controllers;

use App\Enums\TimeEntryTypeEnum;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lastTimeEntryTimestamp = auth()->user()->last_time_entry_timestamp?->format('d/m/Y H:i:s');
        $lastTimeEntryType = auth()->user()->last_time_entry_type;

        $nextTimeEntryType = TimeEntryTypeEnum::IN;
        if ($lastTimeEntryType != null && $lastTimeEntryType == TimeEntryTypeEnum::IN) {
            $nextTimeEntryType = TimeEntryTypeEnum::OUT;
        }

        return view('home', [
            'lastTimeEntryTimestamp' => $lastTimeEntryTimestamp,
            'lastTimeEntryType' => $lastTimeEntryType ? mb_strtoupper(TimeEntryTypeEnum::getDescription($lastTimeEntryType)) : '',
            'nextTimeEntryType' => $nextTimeEntryType ? mb_strtoupper(TimeEntryTypeEnum::getDescription($nextTimeEntryType)) : ''
        ]);
    }
}
