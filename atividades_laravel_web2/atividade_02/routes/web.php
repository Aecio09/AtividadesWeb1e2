<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::resource('livros', LivroController::class);