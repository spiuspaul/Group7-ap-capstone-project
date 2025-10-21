<?php

use Illuminate\Support\Facades\Route;
use App\Presentation\Http\Controllers\ProgramController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\OutcomeController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Program Management Routes
Route::resource('programs', ProgramController::class);
Route::get('programs/{program}/projects', [ProgramController::class, 'projects'])
    ->name('programs.projects');

// Facility Management Routes
Route::resource('facilities', FacilityController::class);
Route::get('facilities/{facility}/equipment', [FacilityController::class, 'equipment'])
    ->name('facilities.equipment');
Route::get('facilities/{facility}/services', [FacilityController::class, 'services'])
    ->name('facilities.services');

// Project Management Routes
Route::resource('projects', ProjectController::class);
Route::get('projects/{project}/participants', [ProjectController::class, 'participants'])
    ->name('projects.participants');

// Service Management Routes
Route::resource('services', ServiceController::class);

// Equipment Management Routes
Route::resource('equipments', EquipmentController::class);

// Participant Management Routes
Route::resource('participants', ParticipantController::class);

// Outcome Management Routes
Route::resource('projects.outcomes', OutcomeController::class);
