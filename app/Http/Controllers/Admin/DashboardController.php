<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $ventasMes = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $comprasMes = Purchase::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        $productosTotales = Product::count();
        $stockTotal = Product::sum('stock');
        $stockTotal = $stockTotal < 0 ? 0 : $stockTotal;
        $topCustomers = Sale::join('customers', 'sales.customer_id', '=', 'customers.id')
        ->selectRaw('customers.name as name, SUM(sales.total) as total_spent')
        ->groupBy('customers.id', 'customers.name')
        ->orderBy('total_spent', 'desc')
        ->take(5)
        ->get();
        $topProducts = \App\Models\Productable::query()
        ->where('productable_type', Sale::class)
        ->join('products', 'productables.product_id', '=', 'products.id')
        ->selectRaw('products.name as name, SUM(productables.quantity) as total_qty')
        ->groupBy('products.id', 'products.name')
        ->orderBy('total_qty', 'desc')
        ->take(5)
        ->get();

        return view('admin.dashboard', compact(
            'ventasMes', 
            'comprasMes', 
            'productosTotales', 
            'stockTotal',
            'topCustomers',
            'topProducts'
        ));
    }
}
