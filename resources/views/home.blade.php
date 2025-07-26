@extends('layouts.app')

@section('content')
    <div class="container-sm mt-3 bg-white shadow rounded p-4 text-center">
        <div class="row mb-3">
            <div class="col-sm">
                <h1>Registro de ponto eletrônico</h1>
            </div>
        </div>
        <div class="row mb-3 align-items-center justify-content-center">
            <div class="col-sm-auto">
                <form action="{{ route('timeEntries.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        REGISTRAR {{ $nextTimeEntryType }}
                    </button>
                </form>
            </div>
        </div>
        <div class="row mb-3 align-items-center justify-content-center">
            <div class="col-sm">
                <span>Último registro:</span>
                <span>{{ $lastTimeEntryTimestamp }}</span>
                <span>{{ $lastTimeEntryType }}</span>
            </div>
        </div>
    </div>
@endsection
