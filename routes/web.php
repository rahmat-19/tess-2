<?php

use App\Http\Controllers\EventContrller;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GreetingController;
use App\Http\Controllers\HalamanDepanController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('location.index'));
});

Route::resource('/location', LocationController::class);
Route::get('/sampling', [LocationController::class, 'indexSampling'])->name('sampling.index');
Route::get('/user', [LocationController::class, 'userIndex'])->name('user.index');
Route::get('/halaman-depan', [HalamanDepanController::class, 'index'])->name('halaman-depan.index');
Route::get('/event', [EventContrller::class, 'index'])->name('event.index');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/greeting', [GreetingController::class, 'index'])->name('greeting.index');


require __DIR__ . '/auth.php';
