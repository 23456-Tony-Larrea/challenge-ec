<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PoblacionController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/permissions', [PermissionController::class, 'getPermissions']);
Route::post('/permissions', [PermissionController::class, 'store']);
Route::get('/permissions/{id}', [PermissionController::class, 'show']);
Route::put('/permissions/{id}', [PermissionController::class, 'update']);

Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles/{id}', [RoleController::class, 'show']);
Route::put('/roles/{id}', [RoleController::class, 'update']);


// Ruta para obtener los permisos de un rol por ID
Route::get('/role-permissions/{roleId}', [RolePermissionController::class, 'getRolePermissionsById']);

// Ruta para actualizar el estado de un permiso de un rol
Route::put('/role-permissions/{roleId}/permissions/{permissionId}', [RolePermissionController::class, 'updateRolePermissionState']);

//usuarios
Route::post('/users', [UserController::class, 'store']);
Route::post('/users-login', [UserController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

//poblacion

Route::post('/poblacion/upload-csv', [PoblacionController::class, 'store']);
Route::get('/poblacion/chart-data', [PoblacionController::class, 'getChartData']);