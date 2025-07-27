<div class="row mt-4">
    <div class="col-sm">
        <h5>Endereço</h5>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-3">
        <label for="zip_code" class="form-label">CEP</label>
        <div class="input-group has-validation">
            <input type="text" name="zip_code" class="form-control cep @error('zip_code') is-invalid @enderror()"
                id="validationZipCode" aria-describedby="validationZipCodeFeedback"
                value="{{ old('zip_code', $user->zip_code) }}">
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
        <input type="text" name="city" id="city" class="form-control @error('city_id') is-invalid @enderror"
            value="{{ $city ?? '' }}" disabled>
        @error('city_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="hidden" name="city_id" id="city_id" value="{{ old('city_id', $user->city_id) }}">
    </div>
    <div class="col-sm-3">
        <label for="state" class="form-label">Estado</label>
        <input type="text" name="state" id="state" class="form-control" value="{{ $state ?? '' }}" disabled>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-3">
        <label for="street" class="form-label">Logradouro</label>
        <input type="text" name="street" id="street" class="form-control @error('street') is-invalid @enderror"
            value="{{ old('street', $user->street) }}">
        @error('street')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-sm-3">
        <label for="number" class="form-label">Número</label>
        <input type="text" name="number" id="number" class="form-control @error('number') is-invalid @enderror"
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
