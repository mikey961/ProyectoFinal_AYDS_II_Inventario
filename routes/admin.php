<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\MovementsController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseOrdersController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\WarehouseController;
use Illuminate\Support\Facades\Route;

//Ruta de dashboard
Route::get('/', function(){
    return view('admin.dashboard');
})->name('dashboard');

// {RUTAS INVENTARIO}

//Ruta de categorías
Route::resource('categories', CategoryController::class)->except(['show']);

//Ruta para importar categorías
Route::get('categories/import', [CategoryController::class, 'import'])->name('categories.import');

//Ruta de productos
Route::resource('products', ProductController::class)->except(['show']);

//Rutas para Dropzone
Route::post('products/{product}/dropzone', [ProductController::class, 'dropzone'])->name('products.dropzone');
Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('image.destroy');

//Ruta del Kardex
Route::get('products/{product}/kardex', [ProductController::class, 'kardex'])->name('products.kardex');

//Ruta para importar productos
Route::get('products/import', [ProductController::class, 'import'])->name('products.import');

//Ruta de Almacenes
Route::resource('warehouses', WarehouseController::class)->except('show');

//Ruta para importar almacenes
Route::get('warehouses/import', [WarehouseController::class, 'import'])->name('warehouses.import');

//{RUTAS DE COMPRAS}

//Ruta de Proveedores
Route::resource('suppliers', SupplierController::class)->except('show');

//Ruta de ordenes de compra
Route::resource('purchase-orders', PurchaseOrdersController::class)->only(['index', 'create']);

//Ruta para los pdf's de ordenes de compra
Route::get('purchase-orders/{purchaseOrder}/pdf', [PurchaseOrdersController::class, 'pdf'])->name('purchase-orders.pdf');

//Ruta de compras
Route::resource('purchases', PurchaseController::class)->only(['index', 'create']);

//Ruta para los pdf's de compras
Route::get('purchases/{purchase}/pdf', [PurchaseController::class, 'pdf'])->name('purchases.pdf');


//{RUTAS DE VENTAS}

//Ruta Clientes
Route::resource('customers', CustomerController::class)->except('show');

//Ruta Cotizaciones
Route::resource('quotes', QuoteController::class)->only(['index', 'create']);

//Ruta para los pdf's de cotizaciones
Route::get('quotes/{quote}/pdf', [QuoteController::class, 'pdf'])->name('quotes.pdf');

//Ruta de ventas
Route::resource('sales', SaleController::class)->only(['index', 'create']);

//Ruta para los pdf's de ventas
Route::get('sales/{sale}/pdf', [SaleController::class, 'pdf'])->name('sales.pdf');

//RUTAS DE MOVIMIENTOS

//Ruta de entradas y salidas
Route::resource('movements', MovementsController::class)->only(['index', 'create']);

//Ruta para los pdf's de movimientos entradas o salidas
Route::get('movements/{movement}/pdf', [MovementsController::class, 'pdf'])->name('movements.pdf');

//Ruta de Transferencias
Route::resource('transfers', TransferController::class)->only(['index', 'create']);

//Ruta para los pdf's de transferencias
Route::get('transfers/{transfer}/pdf', [TransferController::class, 'pdf'])->name('transfers.pdf');

//Ruta de Transferencias

//Ruta de usuarios


//Ruta de roles 


//Ruta de permisos


//Ruta de ajustes