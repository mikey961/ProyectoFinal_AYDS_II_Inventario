<?php

use App\Models\Productable;
use App\Models\Sale;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/prueba', function () {
    return Sale::query()
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->join('identities', 'customers.identity_id', '=', 'identities.id')
            ->selectRaw('
                customers.id as id,
                customers.name as name,
                customers.email as email,
                identities.name as identity_name,
                customers.document_number as document_number,
                customers.phone as phone,
                COUNT(sales.id) as total_purchases
            ')
            ->groupBy(
                'customers.id', 
                'customers.name', 
                'customers.email', 
                'identities.name', 
                'customers.document_number', 
                'customers.phone'
            )
            ->get();
})->name('prueba');