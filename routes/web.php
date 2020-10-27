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
    Route::group(['prefix' => 'posts'], function() {
        Route::post('',[PostController::class, 'store'])->name('posts.store');
        Route::get('create',[PostController::class, 'create'])->name('posts.create');
        Route::get('{post}/edit',[PostController::class, 'edit'])->name('posts.edit');
        Route::patch('{post}',[PostController::class, 'update'])->name('posts.update');
        Route::delete('{post}',[PostController::class, 'destroy'])->name('posts.destroy');
    });
    
    //Comments routes
    Route::group(['prefix' => 'comments'], function() {
        Route::post('{post}', [CommentController::class, 'store'])->name('comments.store');
        Route::post('{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
        Route::delete('{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });
     
});
Route::get('/posts/{post}',[PostController::class, 'show'])->name('posts.show');
Route::get('/', [PostController::class, 'index'])->name('posts.index');