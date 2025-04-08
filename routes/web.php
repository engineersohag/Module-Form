<?php


use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::post('/modules/store', [ModuleController::class, 'store'])->name('modules.store');

