<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// All Inventory & Vehicle Routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // The Dashboard (Vehicle List)
    Route::get('/dashboard', [VehicleController::class, 'index'])->name('dashboard');

    // Vehicle Management
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

    // Parts Management
    // 1. Route to add a manual part to a vehicle
    Route::post('/vehicles/{vehicle}/parts', [VehicleController::class, 'addPart'])->name('parts.store');
    
    // 2. Route for stock adjustments (Quantity +/-)
    Route::patch('/parts/{part}/update-stock', [VehicleController::class, 'updateStock'])->name('parts.update-stock');

    // 3. Route for updating part details (e.g., changing the part number or name)
    Route::put('/parts/{part}', [VehicleController::class, 'updatePart'])->name('parts.update');
});

// Profile Management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';