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
    Route::prefix('organizations/{organization}')->name('organizations.')->group(function () {
        Route::get('units', [OrganizationController::class, 'units'])->name('units.index');
        Route::get('parent', [OrganizationController::class, 'parent'])->name('parent');
        Route::get('children', [OrganizationController::class, 'children'])->name('children');
    });

    Route::apiResource('units', UnitController::class);
    Route::prefix('units/{unit}')->name('units.')->group(function () {
        Route::get('positions', [UnitController::class, 'positions'])->name('positions.index');
        Route::get('parent', [UnitController::class, 'parent'])->name('parent');
        Route::get('children', [UnitController::class, 'children'])->name('children');
    });

    Route::apiResource('positions', PositionController::class);
    Route::get('positions/{position}/employees', [PositionController::class, 'employees'])->name('positions.employees.index');

    Route::apiResource('employees', EmployeeController::class);
    Route::get('employees/{employee}/position', [EmployeeController::class, 'position'])->name('employees.position.show');
});
