<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PurchaseOrdersController extends Controller
{
    public function index()
    {
        return view('admin.purchase-orders.index');
    }

    public function create()
    {
        return view('admin.purchase-orders.create');
    }

    public function pdf(PurchaseOrder $purchaseOrder) {
        $pdf = Pdf::loadView('admin.purchase-orders.pdf', [
            'model' => $purchaseOrder
        ]);

        return $pdf->download("OrdenCompra_{$purchaseOrder->id}.pdf");
    }
}
