<?php
/* */

use Illuminate\Support\Facades\Route;
use InnoShop\Install\Controllers;

Route::get('/install', [Controllers\InstallController::class, 'index'])->name('install.index');
Route::post('/install/driver_detect', [Controllers\InstallController::class, 'driverDetect'])->name('install.driver_detect');
Route::post('/install/connected', [Controllers\InstallController::class, 'checkConnected'])->name('install.connected');
Route::post('/install/complete', [Controllers\InstallController::class, 'complete'])->name('install.complete');
