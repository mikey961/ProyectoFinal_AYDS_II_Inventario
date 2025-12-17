<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Sale;
use Illuminate\Database\Eloquent\Builder;

class TopCustomersTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Sale::query()
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->join('identities', 'customers.identity_id', '=', 'identities.id')
            ->selectRaw('
                customers.id as id,
                customers.name as name,
                customers.email as email,
                identities.name as identity_name,
                customers.document_number as document_number,
                customers.phone as phone,
                COUNT(sales.id) as total_purchases,
                SUM(sales.total) as amount_profit
            ')
            ->groupBy(
                'customers.id', 
                'customers.name', 
                'customers.email', 
                'identities.name', 
                'customers.document_number', 
                'customers.phone'
            );
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('total_purchases', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id")
                ->label(function ($row) {
                    return $row->id;
                })
                ->sortable(),
            Column::make('Identidad')
                ->label(function ($row) {
                    return $row->identity_name;
                })
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('identities.name', $direction);
                }),
            Column::make('Numero de documento')
                ->label(function ($row) {
                    return $row->document_number;
                })
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('customers.document_number', $direction);
                })  
                ->searchable(function ($query, $search) {
                    return $query->orWhere('customers.document_number', 'like', '%' . $search . '%');
                }),
            Column::make("Cliente")
                ->label(function ($row) {
                    return $row->name;
                })
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('name', $direction);
                })
                ->searchable(function ($query, $search) {
                    return $query->orWhere('customers.name', 'like', '%' . $search . '%');
                }),
            Column::make('Email')
                ->label(function ($row) {
                    return $row->email;
                })
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('email', $direction);
                }),
            Column::make('Teléfono')
                ->label(function ($row) {
                    return $row->phone;
                })
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('customers.phone', $direction);
                }),
            Column::make("Total de Ventas")
                ->label(function ($row) {
                    return $row->total_purchases;
                })
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('total_purchases', $direction);
                }),
            Column::make("Monto Total")
                ->label(fn($row) => '₡ ' . number_format($row->amount_profit, 2, '.', ','))
                ->sortable(function ($query, $direction) {
                    return $query->orderBy('amount_profit', $direction);
                })
        ];
    }
}
