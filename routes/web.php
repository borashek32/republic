<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\Site\PostController::class, 'index']);
Route::get('/{id}', [App\Http\Controllers\Site\PostController::class, 'onePost'])
    ->name('onePost');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('dashboard')->group(function () {
    Route::resource('/posts', App\Http\Controllers\Dashboard\PostController::class)
        ->names('posts');
    Route::post('/posts/post_visability', [App\Http\Controllers\Dashboard\PostController::class, 'updateVisability'])
        ->name('posts.visability');
    Route::resource('/users', App\Http\Controllers\Dashboard\UserController::class)
        ->names('users');
});
