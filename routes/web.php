<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ServiveController;
Route::resource('services', ServiceController:: class);
Route::resource('equipment', EquipmentController::class);

