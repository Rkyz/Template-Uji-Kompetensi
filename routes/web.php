<?php

use App\Http\Controllers\ProfileController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user.index')->middleware('admin');
    Route::post('/user/create', [UserController::class, 'store'])->name('register')->middleware('admin');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->middleware('admin');
    Route::put('/user/{id}', [UserController::class, 'edit'])->middleware('admin');

    Route::get('/product', function () {
        return Inertia::render('Product/Main');
    });
    Route::get('/menus', function () {
        return Inertia::render('Menus/Food');
    });
    Route::get('/menus/food', function () {
        return Inertia::render('Menus/Menu');
    });
    Route::get('/history', function () {
        return Inertia::render('History/Main');
    });
});

require __DIR__.'/auth.php';