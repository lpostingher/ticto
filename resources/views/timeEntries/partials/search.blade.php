<form class="mb-3">
    <div class="row mb-3">
        <div class="col-sm">
            <label for="user_id" class="form-label">Usuário</label>
            <select name="user_id" id="user_id" class="form-select">
                <option value="">Todos</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm">
            <label for="role" class="form-label">Cargo</label>
            <select name="role" id="role" class="form-select">
                <option value="">Todos</option>
                @foreach ($roles as $key => $role)
                    <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>
                        {{ $role }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-sm">
            <label for="time_entry_type" class="form-label">Tipo de registro</label>
            <select name="time_entry_type" id="time_entry_type" class="form-select">
                <option value="">Todos</option>
                @foreach ($timeEntryTypes as $key => $type)
                    <option value="{{ $key }}" {{ request('time_entry_type') == $key ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4">
            <label for="timestamp" class="form-label">Período</label>
            <input type="text" name="timestamp" id="timestamp" class="form-control daterange" value="{{ request('timestamp') }}">
        </div>
        <div class="col-sm-auto align-self-end">
            <button class="btn btn-primary" type="submit">
                {{ __('Buscar') }}
            </button>
        </div>
    </div>
</form>
