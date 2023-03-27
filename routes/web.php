<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Author\AuthorPostController;
use App\Models\Category;
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

// Route::get('/', function () {
    //     return view('welcome');
    // })->name('home');

Auth::routes();


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('subscriber', [App\Http\Controllers\SubscriberController::class , 'store'])->name('subscriber.store');

Route::get('/posts', [App\Http\Controllers\PostController::class, 'viewpostsindex'])->name('post.viewindex');
Route::get('/post/{slug}', [App\Http\Controllers\PostController::class, 'viewpostsdetails'])->name('post.viewdetails');
Route::get('/category/{slug}', [App\Http\Controllers\PostController::class, 'postByCategory'])->name('category.posts');
Route::get('/tag/{slug}',[App\Http\Controllers\PostController::class, 'postByTag'])->name('tag.posts');
Route::get('/search',[App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/profile/{username}',[App\Http\Controllers\AuthorController::class, 'profile'])->name('author.createprofile');


Route::group(['middleware'=>['auth']], function (){
    Route::post('favorite/{post}/add',[App\Http\Controllers\FavoriteController::class, 'add'])->name('post.favorite');
    Route::post('comment/{post}',[App\Http\Controllers\CommentController::class, 'store'])->name('comment.store');
});

// Route::group(['as'=>'admin.', 'prefix' => 'admin', 'namespace' => 'admin','middleware' =>['auth','admin']], function () {
//     Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'Admin','middleware'=>['auth','admin']], function (){
    Route::get('dashboard',[App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');


});

Route::resource('admin/tag', TagController::class);
Route::resource('admin/category', CategoryController::class);
Route::resource('admin/post', PostController::class);
Route::put('admin/post/{id}/approve', [PostController::class, 'approval'])->name('post.approve');
Route::get('admin/pending/post', [PostController::class, 'pending'])->name('admin.post.pending');

Route::get('/admin/subscriber', [App\Http\Controllers\Admin\SubscriberController::class , 'index'])->name('admin.subscriber.index');
Route::delete('/admin/subscriber/{subscriber}', [App\Http\Controllers\Admin\SubscriberController::class , 'destroy'])->name('admin.subscriber.destroy');

Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
Route::put('/profile-update', [App\Http\Controllers\Admin\SettingsController::class, 'updateProfile'])->name('admin.profile.update');
Route::put('/password-update', [App\Http\Controllers\Admin\SettingsController::class, 'updatePassword'])->name('admin.password.update');

Route::get('/admin/favorite', [App\Http\Controllers\Admin\FavoriteController::class , 'index'])->name('admin.favorite.index');

Route::get('/admin/comments',[App\Http\Controllers\Admin\CommentController::class , 'index'])->name('admin.comment.index');
Route::delete('/admin/comments/{id}',[App\Http\Controllers\Admin\CommentController::class , 'destroy'])->name('admin.comment.destroy');

Route::get('/admin/authors',[App\Http\Controllers\Admin\AuthorController::class , 'index'])->name('admin.author.index');
Route::delete('/admin/authors/{id}',[App\Http\Controllers\Admin\AuthorController::class , 'destroy'])->name('admin.author.destroy');


// Route::group(['as'=>'author.', 'prefix' => 'author', 'namespace' => 'author','middleware' =>['auth','author']], function () {
//     Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'Author','middleware'=>['auth','author']], function (){
    Route::get('dashboard',[App\Http\Controllers\Author\DashboardController::class, 'index'])->name('dashboard');

});


Route::get('author/create', [App\Http\Controllers\Author\AuthorPostController::class , 'create'])->name('authorpost.create');

Route::resource('author/authorpost', AuthorPostController::class);




Route::get('/author/settings', [App\Http\Controllers\Author\SettingsController::class, 'index'])->name('author.settings');
Route::put('/author/profile-update', [App\Http\Controllers\Author\SettingsController::class, 'updateProfile'])->name('author.profile.update');
Route::put('/author/password-update', [App\Http\Controllers\Author\SettingsController::class, 'updatePassword'])->name('author.password.update');

Route::get('/author/favorite', [App\Http\Controllers\Author\FavoriteController::class , 'index'])->name('author.favorite.index');
// Route::get('/profile/{username}', [App\Http\Controllers\Author\AuthorPostController::class , 'profile'])->name('author.profile');

Route::get('/author/comments',[App\Http\Controllers\Author\CommentController::class , 'index'])->name('author.comment.index');
Route::delete('/author/comments/{id}',[App\Http\Controllers\Author\CommentController::class , 'destroy'])->name('author.comment.destroy');


Route::get('/profile', [App\Http\Controllers\Author\AuthorPostController::class , 'profile'])->name('author.profile');


View::composer('layouts.frontend.partial.footer',function ($view) {
    $categories = App\Models\Category::all();
    $view->with('categories',$categories);
});
