<?php

use App\Http\Controllers\SeriesController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\SeasonController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('series/watchlist', [SeriesController::class, 'indexWatchlist'])->name('series.watchlist');
    Route::get('series/{serie:id}/season/{season:season_number}', [SeasonController::class, 'showEpisodes'])->name('season.show');
    Route::resource('series', SeriesController::class);
    Route::resource('movies', MoviesController::class);
    Route::get('newcontent', [SeriesController::class, 'newEpisodes'])->name('newcontent');
});
