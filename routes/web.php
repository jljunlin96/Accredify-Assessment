<?php

use App\Http\Controllers\Web\AuthenticationController;
use App\Http\Controllers\Web\DocumentFileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::controller(AuthenticationController::class)->group(function(){
    Route::get('login', 'index')->name('login');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:web')->group(function(){
    Route::get('/', [DocumentFileController::class, 'create'])->name('home');

    Route::controller(DocumentFileController::class)->prefix('documents/files')
        ->name('documents.files.')->group(function () {
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
        });
});
