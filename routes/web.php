<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;

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

Route::get('flights', [FlightController::class, 'allFlights']);

Route::get('flights/{type}/{nome}', [FlightController::class, 'flights']);

Route::get('groups', [FlightController::class, 'groups']);

Route::get('groups/id/{id}', [FlightController::class, 'groupsFilter']);

Route::get('groups/cheapestPrice', [FlightController::class, 'groupsFilter']);