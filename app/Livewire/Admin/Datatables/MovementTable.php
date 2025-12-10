<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Movements;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class MovementTable extends DataTableComponent
{
    //protected $model = PurchaseOrder::class;

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
            Column::make("Tipo", "type")
                ->searchable()
                ->sortable()
                ->format(fn ($value) => match ($value) {
                    1 => 'Ingreso',
                    2 => 'Salida',
                    default => 'Desconocido'
                }),
            Column::make("Serie", "serie")
                ->searchable()
                ->sortable(),
            Column::make("Correlativo", "correlative")
                ->sortable(),
            Column::make("Almacén", "warehouse.name")
                ->searchable()
                ->sortable(),
            Column::make("Razón", "reason.name")
                ->searchable()
                ->sortable(),
            Column::make("Total", "total")
                ->sortable()
                ->format(fn ($value) => '₡ ' . number_format($value, 2, '.', ',')),
            Column::make("Acciones")
                ->label(function ($row) {
                    return view('admin.movements.actions', ['movement' => $row]);
                })
        ];
    }

    public function builder(): Builder
    {
        return Movements::query()->with(['warehouse', 'reason']);
    }

    public $form = [
        'open' => false,
        'document' => '',
        'client' => '',
        'email' => '',
        'model' => null,
        'view_pdf_patch' => 'admin.movements.pdf'
    ];

    //Abrirmodal
    public function openModal(Movements $movement)
    {
        $movement_type = match ($movement->type) {
            1 => 'Entrada',
            2 => 'Salida',
            default => 'Desconocido'
        };

        $document_Description = $movement_type . ' ' . $movement->serie . ' - ' . $movement->correlative;

        $this->form['open'] = true;
        $this->form['document'] = $document_Description;
        $this->form['client'] = $movement->warehouse->name . ' - ' . $movement->warehouse->location;
        $this->form['email'] = '';
        $this->form['model'] = $movement;
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