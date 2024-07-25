<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Http\Controllers\AssemblyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GroupController;


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