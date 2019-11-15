<?php

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

Route::prefix('/gene_suggest')->group(
    function () {
        Route::get('/', '\App\Http\Controllers\GeneSuggestController@suggest')
            ->name('api.gene-suggest.search');
    }
);
