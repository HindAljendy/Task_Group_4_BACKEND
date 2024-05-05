<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MessageController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */


// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function ($router) {
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/logout', [AuthController::class, 'logout'])->middleware("auth:api");
//     Route::post('/refresh', [AuthController::class, 'refresh'])->middleware("auth:api");
//     Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware("auth:api");
// });

// Route::middleware("auth:api")->group(function () {

//     /* Routes For MessageController  "ShowMessages and delete */
//     Route::get('/message',[MessageController::class, 'index']);
//     Route::get('/message/{message}',[MessageController::class, 'show']);
//     Route::delete('/message/{message}',[MessageController::class, 'destroy']);


//     /* Routes For ProjectController */




// });

/* Route For MessageController  " StoreMessage */
Route::post('/message',[MessageController::class, 'store']);

Route::get('projects', [ProjectController::class, 'index']);
Route::post('projects', [ProjectController::class, 'store']);
Route::get('projects/{project}', [ProjectController::class, 'show']);
Route::post('projects/{project}', [ProjectController::class, 'update']);
Route::delete('projects/{project}', [ProjectController::class, 'destroy']);

