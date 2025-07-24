<table class="table table-hover table-striped mb-3">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Cargo</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @if (empty($users))
            <tr>
                <td colspan="5" class="text-center">
                    Nenhum usuário cadastrado. <a href="{{ route('users.create') }}">Clique aqui para cadastrar.</a>
                </td>
            </tr>
        @else
            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role_description }}</td>
                    <td class="text-end">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                        @if (Auth::user()->id != $user->id)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Deseja remover este usuário?');">Excluir</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
