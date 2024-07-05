<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;


use App\Http\Controllers\RoutePlannerController;

Route::get('/route-planner', [RoutePlannerController::class, 'show']);
Route::post('/save-route', [RoutePlannerController::class, 'saveRoute']);

Route::redirect("/","/home")->name("dashboard");

Route::middleware(["auth","verified"])->group(function () {

/*
korvaa alla olevan koodin.
Route::get('/note', [NoteController::class,'index'])->name('note.index');
Route::get('/note/create', [NoteController::class,'create'])->name('note.create');
Route::post('/note', [NoteController::class,'store'])->name('note.store');
Route::get('/note/{id}', [NoteController::class,'show'])->name('note.show');
Route::get('/note/{id}/edit', [NoteController::class,'edit'])->name('note.edit');
Route::put('/note/{id}', [NoteController::class,'update'])->name('note.update');
Route::delete('/note/{id}', [NoteController::class,'delete'])->name('note.destroy');
*/
Route::resource('home', NoteController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
