<?php

namespace App\Http\Controllers;

use App\Enums\TimeEntryTypeEnum;
use App\Enums\UserRoleEnum;
use App\Models\TimeEntry;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeEntryController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->buildQuery($request);
        $timeEntries = DB::select($query);

        return view('timeEntries.index', [
            'timeEntries' => $timeEntries,
            'users' => User::all(),
            'timeEntryTypes' => TimeEntryTypeEnum::asSelectArray(),
            'roles' => UserRoleEnum::asSelectArray()
        ]);
    }

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

    private function buildQuery(Request $request): string
    {
        $query = $this->buildMainStructure();

        if ($request->user_id) {
            $query .= " and te.user_id = $request->user_id";
        }

        if ($request->role) {
            $query .=  " and users.role = '$request->role'";
        }

        if ($request->time_entry_type) {
            $query .= " and te.type = $request->time_entry_type";
        }

        if ($request->timestamp) {
            $period = explode(' - ', $request->timestamp);
            $query .= ' and te.timestamp between "'
                . Carbon::createFromFormat('d/m/Y H:i:s', $period[0])->format('Y-m-d H:i:s')
                . '" and "'
                . Carbon::createFromFormat('d/m/Y H:i:s', $period[1])->format('Y-m-d H:i:s') . '"';
        } else {
            $query .= ' and te.timestamp between "'
                . Carbon::now()->startOfDay()->format('Y-m-d H:i:s')
                . '" and "'
                . Carbon::now()->endOfDay()->format('Y-m-d H:i:s') . '"';
        }

        $query .= ' order by te.timestamp desc';

        return $query;
    }

    private function buildMainStructure(): string
    {
        $query = 'select';

        $query .= ' te.id';
        $query .= ' ,users.name as user_name';
        $query .= ' ,manager.name as manager_name';
        $query .= ' , TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) AS user_age';
        $query .= ' ,DATE_FORMAT(te.timestamp, "%d/%m/%Y %H:%i:%s") as timestamp';

        $query .= ' ,CASE';
        $query .= '     WHEN users.role = "admin" THEN "Administrador"';
        $query .= '     ELSE "Funcionário"';
        $query .= '  END as user_role';

        $query .= ' ,CASE';
        $query .= '     WHEN te.type = "1" THEN "Entrada"';
        $query .= '     ELSE "Saída"';
        $query .= '  END as type';

        $query .= ' from time_entries as te';

        $query .= ' inner join users on users.id = te.user_id';
        $query .= ' left join users as manager on manager.id = users.manager_id';

        $query .= ' where 1 = 1';

        return $query;
    }
}
