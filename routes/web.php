<?php


use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('welcome');
});

Route::post('/module', [ModuleController::class, 'module_store'])->name('module.store');

