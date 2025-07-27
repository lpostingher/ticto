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
            @include('users.partials.general')
            @include('users.partials.address')
            @include('users.partials.password')
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
