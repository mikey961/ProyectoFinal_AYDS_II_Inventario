<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

// Ruta de categorías
Route::resource('categories', CategoryController::class)->except(['show']);

//Ruta de productos
Route::resource('products', ProductController::class)->except(['show']);

//Rutas para Dropzone
Route::post('products/{product}/dropzone', [ProductController::class, 'dropzone'])->name('products.dropzone');
Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');

//Rutas Clientes
Route::resource('customers', CustomerController::class)->except('show');

//Rutas de Proveedores
Route::resource('suppliers', SupplierController::class)->except('show');