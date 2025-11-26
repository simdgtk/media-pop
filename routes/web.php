<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Article;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/article/create', [Article::class, 'create']);
Route::post('/article', [Article::class, 'store']);
// Route::get('/articles', function () {
//     return view('articles');
// });
Route::get('/articles', [Article::class, 'index']);
