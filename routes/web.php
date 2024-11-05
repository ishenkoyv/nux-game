<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/generate-new-link', [DashboardController::class, 'generateNewLink'])
        ->name('dashboard.generateNewLink');

    Route::group(['middleware' => ['link_is_active'],], function () {
        Route::get('/dashboard/link/{link}', [DashboardController::class, 'link'])
            ->where(['link' => '[0-9a-zA-Z]{32}'])
            ->name('dashboard.link');
        Route::post('/dashboard/link/{link}/deactivateLink', [DashboardController::class, 'deactivateLink'])
            ->where(['link' => '[0-9a-zA-Z]{32}'])
            ->name('dashboard.deactivateLink');
        Route::post('/dashboard/link/{link}/imfeelinglucky', [DashboardController::class, 'imfeelinglucky'])
            ->where(['link' => '[0-9a-zA-Z]{32}'])
            ->name('dashboard.imfeelinglucky');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
