<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');
Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
