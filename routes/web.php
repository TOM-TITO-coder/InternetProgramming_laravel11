<?php

use App\Http\Controllers\EloquentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [\App\Http\Controllers\EloquentController::class, 'test']);

// api

//create 
Route::post('/author', [EloquentController::class, 'createAuthor']);
Route::post('/article', [EloquentController::class, 'createArticle']);
Route::post('/audience', [EloquentController::class, 'createAudience']);
Route::post('/subscribe', [EloquentController::class, 'subscribe']);
Route::post('/comment', [EloquentController::class, 'comment']);

// get 
Route::get('/audience/{article}', [EloquentController::class, 'getAudience']);
Route::get('/author/{author}', [EloquentController::class, 'getAudienceByAuthor']);
Route::get('/comment/{audience}', [EloquentController::class, 'getCommentByA']);
Route::get('/comments/{topic}', [EloquentController::class, 'getComment']);
