<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\OutcomeController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('programs', ProgramController::class);
Route::resource('facilities', FacilityController::class);
Route::resource('projects', ProjectController::class);
Route::resource('projects.outcomes', OutcomeController::class);

// Extra route for listing projects under a program
Route::get('programs/{program}/projects', [ProgramController::class, 'projects'])->name('programs.projects');
