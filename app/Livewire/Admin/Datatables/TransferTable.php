<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Movements;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class TransferTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Transfer::query()->with(['origin_warehouse', 'destination_warehouse']);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.pdf-modal-email.modal'
            ]
        ]);
    }

    //Aplicar filtros a la tabla 
    public function filters(): array {
        return [
            DateRangeFilter::make('Fecha')
                ->config([
                    'placeholder' => 'Seleccione un rango de fechas'
                ])
                ->filter(function($query, array $dateRange) {
                    $query->whereBetween('date', [
                        $dateRange['minDate'],
                        $dateRange['maxDate']
                    ]);
                })
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Fecha", "date")
                ->sortable()
                ->format(fn ($value) => $value->format('d-m-Y')),
            Column::make("Serie", "serie")
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Almacén Origen", "origin_warehouse.name")
                ->searchable()
                ->sortable(),
            Column::make("Almacén destino", "destination_warehouse.name")
                ->searchable()
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn ($value) => '₡ ' . number_format($value, 2, '.', ',')),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.transfers.actions', ['transfer' => $row]);
                })
        ];
    }

    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.transfers.pdf'
    ];

    //Abrirmodal
    public function openModal(Transfer $transfer)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Transferencia ' . $transfer->serie . ' - ' . $transfer->correlative;
        $this->form['client'] = $transfer->origin_warehouse->name . ' - ' . $transfer->destination_warehouse->name;
        $this->form['email'] = '';
        $this->form['model'] = $transfer;
    }

    //Enviar correo
    public function sendEmail() {
        $this->validate([
            'form.email' => 'required|email'
        ]);

        //Llamar a un mailable
        Mail::to($this->form['email'])
            ->send(new \App\Mail\PdfSend($this->form));

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Correo enviado',
            'text' => 'El correo electrónico ha sido enviado con exito.'
        ]);

        $this->reset('form');
    }

    public function bulkActions(): array
    {
        return [
            'exportSelected' => 'Exportar'
        ];
    }

    public function exportSelected()
    {
        $selected = $this->getSelected();
        $transfer = count($selected) ? Transfer::whereIn('id', $selected)->with(['origin_warehouse', 'destination_warehouse'])
            ->get() : Transfer::with(['origin_warehouse', 'destination_warehouse'])->get();

        return Excel::download(new \App\Exports\TransfersExport($transfer), 'transfers.xlsx');
    }
}