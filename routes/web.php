<?php


Route::get('/', function () {
    return view('welcome');
    }
)->name('welcome');

Route::get('/index', '\App\Http\Controllers\GeneSuggestController@suggestVue')
     ->name('gene-suggest.search');