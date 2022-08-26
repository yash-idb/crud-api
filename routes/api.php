<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Group Middleware
Route::middleware('pin')->group(function()
{    
    Route::post('store',[StudentController::class,'store']);
    Route::get('view/{id?}',[StudentController::class,'view']);
    Route::post('pinsearch',[StudentController::class,'pinsearch']);
    Route::post('update',[StudentController::class,'update']);
    Route::delete('delete/{id}',[StudentController::class,'delete']);
});

//Named Route Middleware

//Route::post('pinsearch',[StudentController::class,'pinsearch'])->middleware('pin');

/*
    Route::post('store',[StudentController::class,'store']);
    Route::get('view/{id?}',[StudentController::class,'view']);
    Route::post('pinsearch',[StudentController::class,'pinsearch']);
    Route::post('update',[StudentController::class,'update']);
    Route::delete('delete/{id}',[StudentController::class,'delete']);
    */
    