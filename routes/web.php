<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('articles', AdminArticleController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
});

// 公開用 記事一覧
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');

// 公開用 記事詳細（slugで取得）
Route::get('/articles/{article:slug}', [ArticleController::class, 'show'])
    ->name('articles.show');

Route::get('/categories/{category:slug}', [ArticleController::class, 'byCategory'])
    ->name('articles.byCategory');

Route::get('/tags/{tag:slug}', [ArticleController::class, 'byTag'])
    ->name('articles.byTag');

require __DIR__ . '/auth.php';
