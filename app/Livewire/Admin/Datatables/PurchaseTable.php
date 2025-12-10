<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Purchase;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class PurchaseTable extends DataTableComponent
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
                }),
            MultiSelectFilter::make('Proveedores')
            ->options(
                Supplier::query()
                    ->orderBy('name')
                    ->get()
                    ->keyBy('id')
                    ->map(fn($tag) => $tag->name)
                    ->toArray()
            
            )
            ->filter(function($query, array $selected) {
                $query->whereIn('supplier_id', $selected);
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
            Column::make("Documento", "supplier.document_number")
                ->sortable(),
            Column::make("Proveedor", "supplier.name")
                ->searchable()
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn ($value) => '₡ ' . number_format($value, 2, '.', ',')),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.purchases.actions', ['purchase' => $row]);
                })
        ];
    }

    public function builder(): Builder
    {
        return Purchase::query()->with(['supplier']);
    }

    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.purchases.pdf'
    ];

    //Abrirmodal
    public function openModal(Purchase $purchase)
    {
        $this->form['open'] = true;
        $this->form['document'] = 'Compra ' . $purchase->serie . ' - ' . $purchase->correlative;
        $this->form['client'] = $purchase->supplier->document_number . ' - ' . $purchase->supplier->name;
        $this->form['email'] = $purchase->supplier->email;
        $this->form['model'] = $purchase;
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