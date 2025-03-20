<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['middleware' => ['auth', 'isAdmin']], function() {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::prefix('project')->group(function () {
        Route::get('list', [ProjectController::class, 'list'])->name('project.list');
        Route::get('create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('store', [ProjectController::class, 'store'])->name('project.store');
        Route::get('edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
        Route::delete('destroy/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');
    });


});



require __DIR__.'/auth.php';
