<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CompetitionController;
//use Illuminate\Support\Facades\Route;

Route::get('/', [CompetitionController::class, 'index'])->name('competitions.index');
Route::get('/competitions/{code}', [CompetitionController::class, 'show'])->name('competitions.show');
Route::get('/competitions/{code}/standings', [CompetitionController::class, 'standings'])->name('competitions.standings');
Route::get('/competitions/{code}/matches', [CompetitionController::class, 'matches'])->name('competitions.matches');
