<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return redirect('/admin');
}); 


Route::get('/create-product', [ProductController::class, 'create']);
Route::get('/show-product/{id}', [ProductController::class, 'show']);
Route::get('/test-recursive-relationships', [ProductController::class, 'testRecursiveRelationships']);
Route::get('/tree', [ProductController::class, 'tree']);
Route::get('/test-additional-methods/{childId}/{parentId}', [ProductController::class, 'testAdditionalMethods']);
