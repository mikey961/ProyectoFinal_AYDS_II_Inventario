<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
}
