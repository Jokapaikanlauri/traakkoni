<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\CommentController;

//Tässä tiedostssa määritetään reitit kohdilleen jotta projektin toiminnallisuutta saadaan hajautettua.

Route::redirect("/","/home")->name("dashboard");
Route::post('/save-route', [RouteController::class, 'saveRoute'])->name('saveRoute');
Route::get('/myroutes', [RouteController::class, 'myroutes'])->name('home.myroutes');

Route::middleware(["auth","verified"])->group(function () {
Route::resource('home', RouteController::class);
Route::post('/routes/{route}/like', [RouteController::class, 'likeRoute']);
Route::post('/routes/{route}/comment', [RouteController::class, 'addComment'])->middleware('auth')->name('route.comment');
Route::resource('routes', RouteController::class)->except(['edit', 'update']);
Route::resource('comments', CommentController::class)->only(['store', 'destroy']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
