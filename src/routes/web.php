<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

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
Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/my/posts', [PostController::class, 'my_posts'])->name('my-posts');
    Route::get('/post/add', [PostController::class, 'add'])->name('add-post');
    Route::post('/post/save', [PostController::class, 'save'])->name('save-post');
    Route::get('/post/edit/{post}', [PostController::class, 'edit'])->name('edit-post');
    Route::post('/post/update/{post}', [PostController::class, 'update'])->name('update-post');
    Route::any('/post/delete/{post}', [PostController::class, 'delete'])->name('delete-post');

    Route::post('/comment/{post}', [PostController::class, 'add_comment'])->name('add-post-comment');
    Route::get('/comment/{post}/delete/{comment}', [PostController::class, 'delete_comment'])->name('delete-comment');
});

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/{post}/{slug}', [PostController::class, 'view'])->name('view-post');


//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
