<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\PositionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('organizations', OrganizationController::class);
    Route::apiResource('units', UnitController::class);
    Route::apiResource('positions', PositionController::class);
    Route::apiResource('employees', EmployeeController::class);
});
