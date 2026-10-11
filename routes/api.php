<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Wajib Bawa Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route CRUD Category
    Route::apiResource('categories', CategoryController::class);
    // Route Location
    Route::apiResource('locations', LocationController::class);
    // Route Asset
    Route::apiResource('assets', AssetController::class);
    // Route Maintenance
    Route::apiResource('maintenances', MaintenanceLogController::class);
    // Route Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);
});