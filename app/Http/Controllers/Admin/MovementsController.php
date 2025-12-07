<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movements;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MovementsController extends Controller
{
    public function index()
    {
        return view('admin.movements.index');
    }

    public function create()
    {
        return view('admin.movements.create');
    }

    public function pdf(Movements $movement) {
        $pdf = Pdf::loadView('admin.movements.pdf', [
            'movement' => $movement
        ]);

        return $pdf->download("Movimiento_" . ($movement->type == 1 ? 'Entrada' : 'Salida') . "_{$movement->id}.pdf");
    }
}