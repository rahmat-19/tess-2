<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('location.index'));
});

Route::resource('/location', LocationController::class);
Route::get('/sampling', [LocationController::class, 'indexSampling'])->name('sampling.index');
Route::get('/user', [LocationController::class, 'userIndex'])->name('user.index');

require __DIR__ . '/auth.php';
