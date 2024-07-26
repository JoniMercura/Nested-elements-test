<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/', function () {
    return redirect('/admin');
}); 

Route::get('/create-product', [ProductController::class, 'create']);
Route::get('/product/{product}', [ProductController::class, 'show']);
Route::get('/test-recursive-relationships', [ProductController::class, 'testRecursiveRelationships']);
Route::get('/tree', [ProductController::class, 'tree']);
Route::get('/test-additional-methods/{childId}/{parentId}', [ProductController::class, 'testAdditionalMethods']);

Route::get('assembly/{assembly}', [AssemblyController::class, 'show']);
Route::get('group/init', [GroupController::class, 'init']);


// Auth
Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('auth/microsoft', [LoginController::class, 'redirectToMicrosoft']);
Route::get('auth/microsoft/callback', [LoginController::class, 'handleMicrosoftCallback']);

