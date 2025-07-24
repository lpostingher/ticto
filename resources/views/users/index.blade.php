@extends('layouts.app')

@section('content')
    <div class="container mt-3 bg-white shadow rounded p-4">
        <div class="row mb-3">
            <div class="col-sm">
                <h1>Usuários</h1>
            </div>
        </div>
        @include('users.partials.search')
        @include('users.partials.table')
        {{ $users->withQueryString()->links() }}
    </div>
@endsection
