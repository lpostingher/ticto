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
            @if ($user->id)
                <input type="hidden" name="id" value="{{ $user->id }}">
            @endif
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
            <div class="row mt-4">
                <div class="col-sm">
                    <h5>Endereço</h5>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="zip_code" class="form-label">CEP</label>
                    <div class="input-group has-validation">
                        <input type="text" name="zip_code"
                            class="form-control cep @error('zip_code') is-invalid @enderror()" id="validationZipCode"
                            aria-describedby="validationZipCodeFeedback" value="{{ old('zip_code', $user->zip_code) }}">
                        <button type="button" class="btn btn-outline-secondary" id="zip_code_search">
                            Buscar
                        </button>
                        <div id="validationZipCodeFeedback" class="invalid-feedback">
                            @error('zip_code')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label for="city" class="form-label">Cidade</label>
                    <input type="text" name="city" id="city"
                        class="form-control @error('city_id') is-invalid @enderror" value="{{ $city ?? '' }}" disabled>
                    @error('city_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id', $user->city_id) }}">
                </div>
                <div class="col-sm-3">
                    <label for="state" class="form-label">Estado</label>
                    <input type="text" name="state" id="state" class="form-control" value="{{ $state ?? '' }}"
                        disabled>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="street" class="form-label">Logradouro</label>
                    <input type="text" name="street" id="street"
                        class="form-control @error('street') is-invalid @enderror"
                        value="{{ old('street', $user->street) }}">
                    @error('street')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="number" class="form-label">Número</label>
                    <input type="text" name="number" id="number"
                        class="form-control @error('number') is-invalid @enderror"
                        value="{{ old('number', $user->number) }}">
                    @error('number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="district" class="form-label">Bairro</label>
                    <input type="text" name="district" id="district"
                        class="form-control @error('district') is-invalid @enderror"
                        value="{{ old('district', $user->district) }}">
                    @error('district')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="complement" class="form-label">Complemento</label>
                    <input type="text" name="complement" id="complement"
                        class="form-control @error('complement') is-invalid @enderror"
                        value="{{ old('complement', $user->complement) }}">
                    @error('complement')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-">
                    <h5>Definição de senha</h5>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" autocomplete="one-time-code">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-sm-3">
                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                        autocomplete="one-time-code">
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

@push('scripts')
    <script type="module">
        $(function() {
            function fetchAddress() {
                $('#zip_code_search').prop('disabled', true);
                const zipCode = $('#validationZipCode').val();

                if (!zipCode) {
                    $('#zip_code_search').prop('disabled', false);
                    return;
                }

                $.ajax({
                    url: '/getAddressByZipCode/' + zipCode,
                    method: 'GET',
                    success: function(response) {
                        $('#zip_code_search').prop('disabled', false);
                        $('#city').val(response.city);
                        $('#city_id').val(response.city_id);
                        $('#state').val(response.state);

                        if (response.street) {
                            $('#street').val(response.street);
                        }

                        if (response.district) {
                            $('#district').val(response.district);
                        }

                        if (response.complement) {
                            $('#complement').val(response.complement);
                        }
                    },
                    error: function() {
                        $('#zip_code_search').prop('disabled', false);
                    }
                })
            }

            $('#zip_code_search').on('click', function() {
                fetchAddress();
            });

            @if (!$user->id && old('zip_code'))
                fetchAddress();
            @endif
        });
    </script>
@endpush
