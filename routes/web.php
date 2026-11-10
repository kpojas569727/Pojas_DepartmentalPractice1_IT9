<?php

use App\Http\Controllers\PlantController;
use App\Http\Controllers\PlantReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Send visitors straight to the plants page
Route::redirect('/', '/plants');

// Every route below requires a logged-in user (protects admin pages)
Route::middleware('auth')->group(function () {

    // Plant CRUD: creates plants.index, plants.create, plants.store,
    // plants.show, plants.edit, plants.update, plants.destroy
    Route::resource('plants', PlantController::class);

    // Reports (named routes)
    Route::get('/reports/plants', [PlantReportController::class, 'index'])->name('reports.plants');
    Route::get('/reports/plants/pdf', [PlantReportController::class, 'pdf'])->name('reports.plants.pdf');
    Route::get('/reports/plants/csv', [PlantReportController::class, 'csv'])->name('reports.plants.csv');

    // Breeze profile routes (keep them)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';