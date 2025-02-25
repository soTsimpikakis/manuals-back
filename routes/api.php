<?php

use App\Http\Controllers\ApiManualController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('manuals', ApiManualController::class);
Route::post("/manuals/{manual}/publish", [ApiManualController::class, 'publish']);
Route::post('manuals/{manual}/materials', [ApiManualController::class, 'addMaterial']);
Route::delete('manuals/{manual}/materials/{material}', [ApiManualController::class, 'removeMaterial']);

