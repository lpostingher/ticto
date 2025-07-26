<table class="table table-hover table-striped mb-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>Funcionário</th>
            <th>Cargo</th>
            <th>Idade</th>
            <th>Gestor</th>
            <th>Data</th>
            <th>Tipo</th>
        </tr>
    </thead>
    <tbody>
        @if (empty($timeEntries))
            <tr>
                <td colspan="7" class="text-center">
                    Nenhum registro encontrado.
                </td>
            </tr>
        @else
            @foreach ($timeEntries as $timeEntry)
                <tr>
                    <td>{{ $timeEntry->id }}</td>
                    <td>{{ $timeEntry->user_name }}</td>
                    <td>{{ $timeEntry->user_role }}</td>
                    <td>{{ $timeEntry->user_age }}</td>
                    <td>{{ $timeEntry->manager_name}}</td>
                    <td>{{ $timeEntry->timestamp }}</td>
                    <td>{{ $timeEntry->type }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
