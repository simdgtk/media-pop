<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Article;
use App\Models\Article as ArticleModel;
use App\Models\Auteur;

Route::get('/', function () {
    $article = \App\Models\Article::first();
    $newsTitle = $article ? $article->title : 'Actualités du jour';
    return view('welcome', ['newsTitle' => $newsTitle]);
});

Route::get('/article-test/{id}', function ($id) {
    $article = ArticleModel::with('auteur')->findOrFail($id);
    return view('article-test', ['article' => $article]);
});


Route::get('/search', function () {
    return view('search');
});

Route::get('/favorite', function () {
    return view('favorite');
})->middleware(['auth', 'verified'])->name('favorite');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/article/create', [Article::class, 'createVue'])
    ->middleware(['auth', 'verified', \App\Http\Middleware\EnsureUserIsAdmin::class])
    ->name('admin.dashboard');

Route::get('/auteurs', function () {
    return response()->json(Auteur::all(['id', 'nom']));
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/article', [Article::class, 'store']);
Route::get('/articles', [Article::class, 'index']);
Route::get('/articles/latest', [Article::class, 'latest']);
Route::get('/articles/{id}', [Article::class, 'show']);
Route::delete('/article/{id}', [Article::class, 'destroy']);

require __DIR__.'/auth.php';
