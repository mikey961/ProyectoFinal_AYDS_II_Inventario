<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function topProducts()
    {
        return view('admin.reports.top-products');
    }

    public function topCustomers()
    {
        return view('admin.reports.top-customers');
    }
}
