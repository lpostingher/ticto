<div class="row mt-4">
    <div class="col-sm-">
        <h5>Definição de senha</h5>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
            autocomplete="one-time-code">
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
