<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseOrdersController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;

//Ruta de dashboard
Route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

// RUTAS INVENTARIO

//Ruta de categorías
Route::resource('categories', CategoryController::class)->except(['show']);

//Ruta de productos
Route::resource('products', ProductController::class)->except(['show']);

//Rutas para Dropzone
Route::post('products/{product}/dropzone', [ProductController::class, 'dropzone'])->name('products.dropzone');
Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');

//Ruta de Almacenes
Route::resource('warehouses', WarehouseController::class)->except('show');

//RUTAS DE COMPRAS

//Ruta de Proveedores
Route::resource('suppliers', SupplierController::class)->except('show');

//Ruta de ordenes de compra
Route::resource('purchase-orders', PurchaseOrdersController::class)->only(['index', 'create']);

//Ruta de compras


//RUTAS DE VENTAS

//Ruta Clientes
Route::resource('customers', CustomerController::class)->except('show');

//Ruta Cotizaciones


//Ruta de ventas


//RUTAS DE MOVIMIENTOS

//Ruta de entradas y salidas


//Ruta de Transferencias


//Ruta de usuarios


//Ruta de roles 


//Ruta de permisos


//Ruta de ajustes