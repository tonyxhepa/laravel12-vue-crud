<?php

use App\Http\Controllers\PostDestroyController;
use App\Http\Controllers\PostEditController;
use App\Http\Controllers\PostIndexController;
use App\Http\Controllers\PostStoreController;
use App\Http\Controllers\PostUpdateController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
   Route::get('posts', PostIndexController::class)->name('posts.index');
   Route::inertia('posts/create', 'posts/Create')->name('posts.create');
   Route::post('posts', PostStoreController::class)->name('posts.store');
   Route::get('posts/{post}/edit', PostEditController::class)->name('posts.edit');
   Route::put('posts/{post}', PostUpdateController::class)->name('posts.update');
   Route::delete('posts/{post}', PostDestroyController::class)->name('posts.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
