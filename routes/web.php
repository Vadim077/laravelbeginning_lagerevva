<?php

use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FormController::class, 'showForm'])->name('form.show');
Route::post('/submit', [FormController::class, 'submitForm'])->name('form.submit');
Route::get('/submissions', [FormController::class, 'showSubmissions'])->name('submissions.index');

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::get('/{id}', [PostController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
    Route::put('/{id}', [PostController::class, 'update'])->name('update');
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/comments', [PostController::class, 'addComment'])->name('comments.store');
});

Route::prefix('api/posts')->name('api.posts.')->group(function () {
    Route::get('/', [PostApiController::class, 'index'])->name('index');
    Route::post('/', [PostApiController::class, 'store'])->name('store');
    Route::get('/{id}', [PostApiController::class, 'show'])->name('show');
    Route::put('/{id}', [PostApiController::class, 'update'])->name('update');
    Route::delete('/{id}', [PostApiController::class, 'destroy'])->name('destroy');
});
