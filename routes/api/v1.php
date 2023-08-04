<?php

use App\Http\Controllers\API\v1\DocumentFileController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'as' => 'v1.',
], function () {
    Route::controller(DocumentFileController::class)->group(function(){
        Route::post('documents/files/store', 'store')->name('documents.files.store');
    });
});
