<?php

namespace App\Livewire\Admin\Datatables;

use App\Models\Inventory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use BcMath\Number;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;

class ProductTable extends DataTableComponent
{
    //protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id', 'desc');
        $this->setConfigurableAreas([
            'after-wrapper' => [
                'admin.products.modal'
            ]
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            ImageColumn::make("Imagen")
                ->location(fn($row) => $row->image)
                ->attributes(fn($row) => [
                    'class' => 'image-product'
                ]),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Categoría", "category.name")
                ->searchable()
                ->sortable(),
            Column::make("Precio", "price")
                ->sortable()
                ->format(fn($value) => '₡ ' . number_format($value, 2, '.', ',')),
            Column::make("Stock", "stock")
                ->sortable()
                ->format(function($value, $row) {
                    return view('admin.products.stock', [
                        'stock' => $value,
                        'product' => $row
                    ]);
                }),
            Column::make("Acciones")
                ->label(function($row) {
                    return view('admin.products.actions', ['product' => $row]);
                })
        ];
    }

    public function builder(): Builder
    {
        return Product::query()->with(['category', 'images']);
    }

    //Propiedades
    public $openModal = false;
    public $inventories = [];

    //Mostrar modal
    public function showStockModal($productId) {
        $this->openModal = true;
        $latestInventories = Inventory::where('product_id', $productId)
            ->select('warehouse_id' ,DB::raw('MAX(id) as id'))
            ->groupBy('warehouse_id')
            ->pluck('id');
        $this->inventories = Inventory::whereIn('id', $latestInventories)
            ->with('warehouse')
            ->get();
    }
}