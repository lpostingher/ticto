<?php

use App\Http\Controllers\GetAddressByZipCodeController;
use App\Http\Controllers\TimeEntryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class)
    ->except('show')
    ->middleware(['auth', 'admin']);

Route::get('/getAddressByZipCode/{zip_code}', GetAddressByZipCodeController::class)->name('getAddressByZipCode');

Route::post('timeEntries', [TimeEntryController::class, 'store'])
    ->middleware(['auth'])
    ->name('timeEntries.store');
Route::get('timeEntries', [TimeEntryController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('timeEntries.index');
