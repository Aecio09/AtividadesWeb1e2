<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tickets', App\Http\Controllers\TicketController::class);
Route::resource('events', App\Http\Controllers\EventController::class);