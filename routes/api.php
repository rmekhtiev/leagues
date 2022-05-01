<?php

use App\Http\Controllers\Api\V1\LeagueController;
use App\Http\Controllers\Api\V1\MatchController;
use App\Http\Controllers\Api\V1\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'leagues/{league}'], function () {
    Route::get('/stats', [LeagueController::class, 'stats']);
    Route::post('/simulate', [LeagueController::class, 'simulate']);
    Route::post('/reset', [LeagueController::class, 'reset']);
});
Route::apiResource('leagues', LeagueController::class);
Route::apiResource('matches', MatchController::class);
Route::apiResource('teams', TeamController::class);
