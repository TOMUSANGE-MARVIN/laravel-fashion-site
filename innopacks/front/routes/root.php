<?php
/* */

use Illuminate\Support\Facades\Route;
use InnoShop\Front\Controllers;
use InnoShop\Front\Controllers\Account;

Route::get('/', [Controllers\HomeController::class, 'index'])->name('home.index');

// Social
Route::get('/social/{provider}/redirect', [Account\SocialController::class, 'redirect'])->name('social.redirect');
Route::get('/social/{provider}/callback', [Account\SocialController::class, 'callback'])->name('social.callback');

// Upload
Route::post('/upload/images', [Controllers\UploadController::class, 'images'])->name('upload.images');
Route::post('/upload/docs', [Controllers\UploadController::class, 'docs'])->name('upload.docs');
Route::post('/upload/files', [Controllers\UploadController::class, 'files'])->name('upload.files');

// Sitemap
Route::get('/sitemap.xml', [Controllers\SitemapController::class, 'index'])->name('sitemap.index');
