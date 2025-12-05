<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Movements;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;

class MovementTable extends DataTableComponent
{
    //protected $model = PurchaseOrder::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
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
}