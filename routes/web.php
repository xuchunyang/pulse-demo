<?php

use App\Http\Controllers\Just4Fun;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'status' => session('status'),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('users', UserController::class)
    ->middleware(['auth', 'verified']);

Route::resource('movies', MovieController::class)
    ->middleware(['auth', 'verified']);

Route::get('/seo', SeoController::class)
    ->middleware(['auth', 'verified'])->name('seo');

Route::post('/relax-and-have-fun', Just4Fun::class)
    ->middleware(['auth', 'verified'])->name('relax-and-have-fun');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
