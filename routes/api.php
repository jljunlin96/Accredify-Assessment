<?php

use App\Http\Controllers\API\AuthenticationController;
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

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('login', 'login');
    Route::get('me', 'show')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    require base_path('routes/api/v1.php');
});
