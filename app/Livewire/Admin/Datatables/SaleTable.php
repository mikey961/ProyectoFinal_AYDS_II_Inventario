<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Purchase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class SaleTable extends DataTableComponent
{
    //protected $model = Purchase::class;

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
                ->searchable()
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Documento", "customer.document_number")
                ->sortable(),
            Column::make("Cliente", "customer.name")
                ->searchable()
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn ($value) => '₡ ' . number_format($value, 2, '.', ',')),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.sales.actions', ['sale' => $row]);
                })
        ];
    }

    public function builder(): Builder
    {
        return Sale::query()->with(['customer']);
    }

    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.sales.pdf'
    ];

    //Abrirmodal
    public function openModal(Sale $sale)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Venta ' . $sale->serie . ' - ' . $sale->correlative;
        $this->form['client'] = $sale->customer->document_number . ' - ' . $sale->customer->name;
        $this->form['email'] = $sale->customer->email;
        $this->form['model'] = $sale;
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
}