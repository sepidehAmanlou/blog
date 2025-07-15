<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;



Route::prefix('/blogs')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::post('/store', [BlogController::class, 'store'])->name('store');
    Route::get('/show/{id}', [BlogController::class, 'show'])->name('show');
    Route::put('/update/{blog}', [BlogController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [BlogController::class, 'softDelete'])->name('softDelete');
    Route::delete('/delete/{id}',[BlogController::class,'destroy'])->name('destroy');
});

Route::prefix('/categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/show/{id}', [CategoryController::class, 'show'])->name('show');
    Route::put('/update/{category}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

Route::prefix('/tags')->name('tags.')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('index');
    Route::post('/store', [TagController::class, 'store'])->name('store');
    Route::get('/show/{id}', [TagController::class, 'show'])->name('show');
    Route::put('/update/{tag}', [TagController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [TagController::class, 'destroy'])->name('destroy');
});

Route::prefix('/blogs/tags')->name('blogTag.')->group(function () {
    Route::post('/attach', [BlogTagController::class, 'attachTag'])->name('attachTag');
    Route::delete('/detach', [BlogTagController::class, 'detachTag'])->name('detachTag');

});

