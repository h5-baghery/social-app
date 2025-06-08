<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RateAndCommentController;
use App\Http\Controllers\UserController;
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

// user related routes
Route::get('/', [UserController::class, 'homepage'])->name('login');
Route::post('/register', [UserController::class, 'register'])->middleware('guest')->name('register');
Route::post('/login', [UserController::class, 'login'])->middleware('guest')->name('login.post');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/profile/{user:username}/posts', [UserController::class, 'userProfile'])->name('user.profile');
Route::get('/profile/{user:username}/followers', [UserController::class, 'userProfileFollowers'])->name('user.profile.followers');
Route::get('/profile/{user:username}/followings', [UserController::class, 'userProfileFollowings'])->name('user.profile.followings');
Route::get('/upload-avatar-image', [UserController::class, 'uploadAvatarImageForm'])->middleware('auth')->name('avatar.upload');
Route::post('/upload-avatar-image', [UserController::class, 'avatarImageSave'])->middleware('auth')->name('avatar.save');

// custom middleware test
Route::get('/test', [UserController::class, 'test'])->middleware('mustBeLoggedIn')->name('test');

// post related routes
Route::get('/create-post', [PostController::class, 'showCreateForm'])->name('createpost')->middleware('auth');
Route::post('/create-post-save', [PostController::class, 'createPost'])->name('createpost.save')->middleware('auth');
Route::put('/post-update/{post}', [PostController::class, 'editPost'])->name('createpost.update')->middleware('auth');
Route::get('/post/{post}', [PostController::class, 'showSinglePost'])->name('singlepost');
Route::get('/post/{post}/edit', [PostController::class, 'showEditSinglePost'])->name('editpost')->middleware('can:update,post');
Route::delete('/post/{post}/delete', [PostController::class, 'deletePost'])->name('post.delete')->middleware('can:delete,post');
Route::get('/search/{term}', [PostController::class, 'search'])->name('search');

// Rate and Comments routes
Route::post('/posts/{post}/comments', [RateAndCommentController::class, 'store'])
    ->name('comments.store')
    ->middleware('auth');

Route::delete('/comments/{comment}', [RateAndCommentController::class, 'destroy'])
    ->name('comments.destroy')
    ->middleware('auth');
Route::post('/posts/{post}/rate', [PostController::class, 'rate'])->name('posts.rate')->middleware('auth');

Route::get('/explorer', [PostController::class, 'explorer'])->name('explorer');

// follow related routes
Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('follow')->middleware('auth');
Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow')->middleware('auth');
