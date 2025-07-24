<form class="mb-3">
    <div class="row">
        <div class="col-sm">
            <input type="search" name="search" class="form-control" value="{{ request('search') }}"
                placeholder="Pesquisar usuário por nome ou e-mail...">
        </div>
        <div class="col-sm-auto">
            <button class="btn btn-primary" type="submit">
                {{ __('Pesquisar') }}
            </button>
        </div>
        <div class="col-sm-auto">
            <a href="{{ route('users.create') }}" class="btn btn-outline-primary">
                {{ __('Criar novo usuário') }}
            </a>
        </div>
    </div>
</form>
