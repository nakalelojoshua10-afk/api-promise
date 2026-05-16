<?php

use App\Http\Controllers\StoreBalanceController;
use App\Http\Controllers\StoreBalanceHistoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('user', UserController::class);
Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);

Route::apiResource('store', StoreController::class);
Route::get('store/all/paginated', [StoreController::class, 'getAllPaginated']);
Route::post('store/{id}/verified', [StoreController::class, 'updateVerifiedStatus']);

Route::apiResource('store-balance', StoreBalanceController::class)->except(['store', 'update', 'destroy']);
Route::get('store-balance/all/paginated', [StoreBalanceController::class, 'getAllPaginated']);

// 💡 FIXED HERE: 
// 1. Always place specific GET paths BEFORE the wildcard apiResource route
Route::get('store-balance-history/all/paginated', [StoreBalanceHistoryController::class, 'getAllPaginated']);

// 2. Add ->except() or explicitly list routes so the API compiler doesn't auto-generate broken bindings
Route::apiResource('store-balance-history', StoreBalanceHistoryController::class)->only(['index', 'store']);