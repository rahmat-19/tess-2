<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GreetingController;
use App\Http\Controllers\Api\RekeningController;
use App\Http\Controllers\Api\EventUserController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\PreweddingImageController;
use App\Http\Controllers\Api\Authentication\AuthenticationController;
use App\Http\Controllers\Api\RekeningUserController;
use App\Http\Controllers\Api\SubdomainController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // logout
    Route::post('/logout', [AuthenticationController::class, 'logout']);

    // profile
    Route::get('/user-detail', [AuthenticationController::class, 'profile']);

    // user
    Route::middleware(['authorize:manage:all,read:user'])->get('/user', [UserController::class, 'index']);
    Route::middleware(['authorize:manage:all,show:user'])->get('/user/{id}/show', [UserController::class, 'show']);
    Route::middleware(['authorize:manage:all,create:user'])->post('/user/create', [UserController::class, 'store']);
    Route::middleware(['authorize:manage:all,update:user'])->patch('/user/{id}/edit', [UserController::class, 'update']);
    Route::middleware(['authorize:manage:all,delete:user'])->delete('/user/{id}/delete', [UserController::class, 'delete']);

    // prewedding_images
    Route::middleware(['authorize:manage:all'])->get('prewedding_images', [PreweddingImageController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('prewedding_images/{id}/show', [PreweddingImageController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('prewedding_images/create', [PreweddingImageController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->post('prewedding_images/createMany', [PreweddingImageController::class, 'storeMany']);
    Route::middleware(['authorize:manage:all'])->patch('prewedding_images/{id}/edit', [PreweddingImageController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('prewedding_images/{id}/delete', [PreweddingImageController::class, 'delete']);
    Route::middleware(['authorize:manage:all'])->delete('prewedding_images/deleteMany', [PreweddingImageController::class, 'deleteMany']);

    // event_user
    Route::middleware(['authorize:manage:all'])->get('event_user', [EventUserController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('event_user/{id}/show', [EventUserController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('event_user/create', [EventUserController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->patch('event_user/{id}/edit', [EventUserController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('event_user/{id}/delete', [EventUserController::class, 'delete']);

    // rekening
    Route::middleware(['authorize:manage:all'])->get('rekening', [RekeningController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('rekening/{id}/show', [RekeningController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('rekening/create', [RekeningController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->patch('rekening/{id}/edit', [RekeningController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('rekening/{id}/delete', [RekeningController::class, 'delete']);

    // role
    Route::middleware(['authorize:manage:all'])->get('role', [RoleController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('role/{id}/show', [RoleController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('role/create', [RoleController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->patch('role/{id}/edit', [RoleController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('role/{id}/delete', [RoleController::class, 'delete']);

    // greeting
    Route::middleware(['authorize:manage:all'])->get('greeting', [GreetingController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('greeting/{id}/show', [GreetingController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('greeting/create', [GreetingController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->patch('greeting/{id}/edit', [GreetingController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('greeting/{id}/delete', [GreetingController::class, 'delete']);

    // permission
    Route::middleware(['authorize:manage:all'])->get('permission', [PermissionController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('permission/{id}/show', [PermissionController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('permission/create', [PermissionController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->patch('permission/{id}/edit', [PermissionController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('permission/{id}/delete', [PermissionController::class, 'delete']);

    // subdomain
    Route::middleware(['authorize:manage:all'])->get('subdomain', [SubdomainController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->get('subdomain/{id}/show', [SubdomainController::class, 'show']);
    Route::middleware(['authorize:manage:all'])->post('subdomain/create', [SubdomainController::class, 'store']);
    Route::middleware(['authorize:manage:all'])->patch('subdomain/{id}/edit', [SubdomainController::class, 'update']);
    Route::middleware(['authorize:manage:all'])->delete('subdomain/{id}/delete', [SubdomainController::class, 'delete']);

    // role_permission
    Route::middleware(['authorize:manage:all'])->get('role_permission', [RolePermissionController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->post('role_permission/{roleId}/assign', [RolePermissionController::class, 'assignPermission']);

    // rekening_user
    Route::middleware(['authorize:manage:all'])->get('rekening_user', [RekeningUserController::class, 'index']);
    Route::middleware(['authorize:manage:all'])->post('rekening_user/{userId}/add', [RekeningUserController::class, 'addRekening']);

    
});
