<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GreetingController;
use App\Http\Controllers\Api\RekeningController;
use App\Http\Controllers\Api\UserRoleController;
use App\Http\Controllers\Api\EventUserController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserPermissionController;
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
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}/show', [UserController::class, 'show']);
    Route::post('/user/create', [UserController::class, 'store']);
    Route::patch('/user/{id}/edit', [UserController::class, 'update']);
    Route::post('/user/{id}/delete', [UserController::class, 'delete']);

    // prewedding_images
    Route::get('prewedding_images', [PreweddingImageController::class, 'index']);
    Route::get('prewedding_images/{id}/show', [PreweddingImageController::class, 'show']);
    Route::post('prewedding_images/create', [PreweddingImageController::class, 'store']);
    Route::patch('prewedding_images/{id}/edit', [PreweddingImageController::class, 'update']);
    Route::post('prewedding_images/{id}/delete', [PreweddingImageController::class, 'delete']);

    // event_user
    Route::get('event_user', [EventUserController::class, 'index']);
    Route::get('event_user/{id}/show', [EventUserController::class, 'show']);
    Route::post('event_user/create', [EventUserController::class, 'store']);
    Route::patch('event_user/{id}/edit', [EventUserController::class, 'update']);
    Route::delete('event_user/{id}/delete', [EventUserController::class, 'delete']);

    // rekening
    Route::get('rekening', [RekeningController::class, 'index']);
    Route::get('rekening/{id}/show', [RekeningController::class, 'show']);
    Route::post('rekening/create', [RekeningController::class, 'store']);
    Route::patch('rekening/{id}/edit', [RekeningController::class, 'update']);
    Route::post('rekening/{id}/delete', [RekeningController::class, 'delete']);

    // role
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/{id}/show', [RoleController::class, 'show']);
    Route::post('role/create', [RoleController::class, 'store']);
    Route::patch('role/{id}/edit', [RoleController::class, 'update']);
    Route::post('role/{id}/delete', [RoleController::class, 'delete']);

    // greeting
    Route::get('greeting', [GreetingController::class, 'index']);
    Route::get('greeting/{id}/show', [GreetingController::class, 'show']);
    Route::post('greeting/create', [GreetingController::class, 'store']);
    Route::patch('greeting/{id}/edit', [GreetingController::class, 'update']);
    Route::post('greeting/{id}/delete', [GreetingController::class, 'delete']);

    // permission
    Route::get('permission', [PermissionController::class, 'index']);
    Route::get('permission/{id}/show', [PermissionController::class, 'show']);
    Route::post('permission/create', [PermissionController::class, 'store']);
    Route::patch('permission/{id}/edit', [PermissionController::class, 'update']);
    Route::post('permission/{id}/delete', [PermissionController::class, 'delete']);

    // subdomain
    Route::get('subdomain', [SubdomainController::class, 'index']);
    Route::get('subdomain/{id}/show', [SubdomainController::class, 'show']);
    Route::post('subdomain/create', [SubdomainController::class, 'store']);
    Route::patch('subdomain/{id}/edit', [SubdomainController::class, 'update']);
    Route::post('subdomain/{id}/delete', [SubdomainController::class, 'delete']);

    // user_role
    Route::get('user_role', [UserRoleController::class, 'index']);
    Route::post('user_role/{userId}/assign', [UserRoleController::class, 'assignRole']);

    // user_permission
    Route::get('user_permission', [UserPermissionController::class, 'index']);
    Route::post('user_permission/{userId}/assign', [UserPermissionController::class, 'assignPermission']);

    // rekening_user
    Route::get('rekening_user', [RekeningUserController::class, 'index']);
    Route::post('rekening_user/{userId}/add', [RekeningUserController::class, 'addRekening']);
});
