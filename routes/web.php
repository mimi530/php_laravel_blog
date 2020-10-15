<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['auth']], function() {
    //Post routes
    Route::post('/posts',[PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/create',[PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}/edit',[PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}',[PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}',[PostController::class, 'destroy'])->name('posts.destroy');

    //Comments routes
    Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
     
});
Route::get('/posts/{post}',[PostController::class, 'show'])->name('posts.show');
Route::get('/', [PostController::class, 'index'])->name('posts.index');