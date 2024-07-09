<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;


use App\Http\Controllers\RoutePlannerController;



Route::redirect("/","/home")->name("dashboard");
Route::post('/save-route', [RouteController::class, 'saveRoute'])->name('saveRoute');
Route::middleware(["auth","verified"])->group(function () {
/*
korvaa alla olevan koodin.
Route::get('/note', [RouteController::class,'index'])->name('note.index');
Route::get('/note/create', [RouteController::class,'create'])->name('note.create');
Route::post('/note', [RouteController::class,'store'])->name('note.store');
Route::get('/note/{id}', [RouteController::class,'show'])->name('note.show');
Route::get('/note/{id}/edit', [RouteController::class,'edit'])->name('note.edit');
Route::put('/note/{id}', [RouteController::class,'update'])->name('note.update');
Route::delete('/note/{id}', [RouteController::class,'delete'])->name('note.destroy');
*/
Route::resource('home', RouteController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
