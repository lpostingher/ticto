@extends('layouts.app')

@section('content')
    <div class="container bg-white shadow rounded p-4 mt-3">
        <div class="row mb-3">
            <div class="col-sm">
                <h1>Registros de ponto eletrônico</h1>
            </div>
        </div>
        @include('timeEntries.partials.search')
        @include('timeEntries.partials.table')
    </div>
@endsection
