<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\homecontroller::class, 'index']);
Route::get('games', [App\Http\Controllers\GameController::class, 'index'])->name('games.index');
Route::get('games/create', [App\Http\Controllers\GameController::class, 'create'])->name('games.create');
Route::post('games', [App\Http\Controllers\GameController::class, 'store'])->name('games.store');
Route::get('games/{id}/edit', [App\Http\Controllers\GameController::class, 'edit'])->name('games.edit');
Route::put('games/{game}', [App\Http\Controllers\GameController::class, 'update'])->name('games.update');
Route::delete('games/{id}', [App\Http\Controllers\GameController::class, 'destroy'])->name('games.destroy');

