<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DemoController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    return "Test";
    });


Route::get('/demo', [DemoController::class,'index'] );
Route::get('/demo2', [DemoController::class,'index2'] );
Route::get('/demo3', [DemoController::class,'index3'] );
Route::get('/demo4/{id}', [DemoController::class,'index4']);
Route::get('/demo5/{id?}', [DemoController::class,'index5']);
Route::get('/demo6/{parram1}/{parram2}', [DemoController::class, 'index6']);