@extends('layouts.app')

@section('content')
    <div class="container bg-white shadow rounded p-4">
        <div class="row mb-3">
            <div class="col-sm">
                <h1>{{ $pageTitle }}</h1>
            </div>
        </div>
        <form action="{{ $action }}" method="POST">
            @csrf
            @method($method)
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="taxvat_number" class="form-label">CPF</label>
                    <input type="text" name="taxvat_number" id="taxvat_number"
                        class="form-control cpf @error('taxvat_number') is-invalid @enderror"
                        value="{{ old('taxvat_number', $user->taxvat_number) }}">
                    @error('taxvat_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="birth_date" class="form-label">Data de nascimento</label>
                    <input type="date" name="birth_date" id="birth_date"
                        class="form-control @error('birth_date') is-invalid @enderror"
                        value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">
                    @error('birth_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="role" class="form-label">Cargo</label>
                    <select name="role" id="role" class="form-select">
                        @foreach ($roles as $key => $role)
                            <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                {{ $role }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-auto">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
@endsection
