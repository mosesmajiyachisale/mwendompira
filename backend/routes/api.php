<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('settings/qualifications', App\Http\Controllers\QualificationController::class);
Route::resource('settings/locations', App\Http\Controllers\LocationController::class);
Route::resource('settings/stadiums', App\Http\Controllers\StadiumController::class);
Route::resource('settings/tournaments', App\Http\Controllers\TournamentController::class);
Route::resource('settings/seasons', App\Http\Controllers\SeasonController::class);
Route::resource('settings/sponsors', App\Http\Controllers\SponsorController::class);
Route::resource('settings/sponsorships', App\Http\Controllers\SponsorshipController::class);
Route::resource('settings/participations', App\Http\Controllers\ParticipationController::class);
Route::resource('settings/teams', App\Http\Controllers\TeamController::class);
Route::resource('settings/fields', App\Http\Controllers\FieldController::class);
Route::resource('settings/formations', App\Http\Controllers\FormationController::class);
Route::resource('settings/positions', App\Http\Controllers\PositionController::class);

Route::resource('settings/players', App\Http\Controllers\PlayerController::class);
Route::resource('settings/team_players', App\Http\Controllers\TeamPlayerController::class);
Route::resource('settings/providers', App\Http\Controllers\ProviderController::class);
Route::resource('settings/coaches', App\Http\Controllers\CoachController::class);


Route::resource('settings/phases', App\Http\Controllers\PhaseController::class);
Route::resource('settings/stages', App\Http\Controllers\StageController::class);
