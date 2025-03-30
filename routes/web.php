<?php

use App\Http\Controllers\Backend\FolderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return Inertia::render('Dashboard');
//     })->name('dashboard');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('api')->as('api.')->group(function () {
    Route::get('/folders', [FolderController::class, 'index'])->name('folder.index');
    Route::get('/folder/{folder}/files', [FolderController::class, 'showFile'])->name('folder.show-file');
    Route::get('/members', [UserController::class, 'index'])->name('user.index');
});
