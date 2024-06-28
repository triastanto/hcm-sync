<?php

use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\PositionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('units', UnitController::class);
Route::apiResource('organizations', OrganizationController::class);
Route::get('organizations/{organization}/children', [OrganizationController::class, 'children']);
Route::get('organizations/{organization}/parent', [OrganizationController::class, 'parent']);
Route::apiResource('positions', PositionController::class);
Route::apiResource('employees', EmployeeController::class);
