<?php

use App\Http\Controllers\CommandsController;
use App\Http\Controllers\GridController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::middleware('api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')
    ->prefix('/commands')
    ->group(function () {
        Route::get('/', [
            CommandsController::class,
            'list'
        ]);
        Route::post('/', [
            CommandsController::class,
            'store'
        ]);
        Route::get('/generate', [
            CommandsController::class,
            'generate'
        ]);
    });

Route::middleware('api')
    ->prefix('/grid')
    ->group(function () {
        Route::get('/', [
            GridController::class,
            'list'
        ]);

        Route::get('/generate', [
            GridController::class,
            'generate'
        ]);
    });
