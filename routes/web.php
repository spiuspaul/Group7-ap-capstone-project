<?php
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProgramController;
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

Route::resource('programs', ProgramController::class);
Route::resource('facilities', FacilityController::class);
Route::resource('projects', ProjectController::class);
Route::resource('services', ServiceController::class);
Route::resource('equipments', EquipmentController::class);
Route::resource('participants', ParticipantController::class);
Route::resource('projects.outcomes', OutcomeController::class);

Route::get('programs/{program}/projects', [ProgramController::class, 'projects'])->name('programs.projects');
Route::get('facilities/{facility}/equipment', [FacilityController::class, 'equipment'])->name('facilities.equipment');
Route::get('facilities/{facility}/services', [FacilityController::class, 'services'])->name('facilities.services');
Route::get('projects/{project}/participants', [ProjectController::class, 'participants'])->name('projects.participants');
