<?php

namespace App\Livewire\Admin;

use App\Models\Inventory;
use App\Models\Movements;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Livewire\Component;

class MovementCreate extends Component
{
    public $type = 1;
    public $serie = "M001";
    public $correlative;
    public $date;
    public $warehouse_id;
    public $reason_id;
    public $total = 0;
    public $observation;
    public $product_id;
    public $products = [];

    public function boot() {
        //Verificar si hay algun error de validación previo
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                if (isset($errors['products'])) {
                    $this->dispatch('swal', [
                        'icon' => 'error',
                        'title' => 'No hay productos seleccionados',
                        'text' => 'Debes agregar al menos un producto antes de realizar la orden de compra.'
                    ]);
                }
            }
        });
    }

    public function mount() {
        $this->correlative = Movements::max('correlative') + 1;
    }

    public function updated($property, $value) {
        if ($property == 'type') {
            $this->reset('reason_id');
        }
    }

    public function addProduct() {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id'
        ],[],[
            'product_id' => 'producto',
            'warehouse_id' => 'almacén'
        ]);
        
        $existing = collect($this->products)
            ->firstWhere('id', $this->product_id);
        if ($existing) {
            $this->dispatch('swal', [
                'icon' => 'warning',
                'title' => 'Producto ya agregado',
                'text' => 'El producto ya se encuentra en la lista'
            ]);
            return;
        }

        $product = Product::find($this->product_id);
        $lastKardex = Inventory::where('product_id', $product->id)
                ->where('warehouse_id', $this->warehouse_id)
                ->latest('id')
                ->first();
        $costBalance = $lastKardex?->cost_balance ?? 0;

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $costBalance,
            'subtotal' => $costBalance
        ];
        $this->reset('product_id');
    }

    public function save() {
        $this->validate([
            'type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|numeric|min:1',
            'date' => 'nullable|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'reason_id' => 'required|exists:reasons,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'type' => 'tipo de movimiento',
            'warehouse_id' => 'almacén',
            'reason_id' => 'motivo',
            'observation' => 'observación',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $movement = Movements::create([
            'type' => $this->type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'warehouse_id' => $this->warehouse_id,
            'total' => $this->total,
            'observation' => $this->observation,
            'reason_id' => $this->reason_id
        ]);

        foreach ($this->products as $product) {
            $movement->product()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            //Kardex
            $lastKardex = Inventory::where('product_id', $product['id'])
                ->where('warehouse_id', $this->warehouse_id)
                ->latest('id')
                ->first();

            $lastQuantityBalance = $lastKardex?->quantity_balance ?? 0;
            $lastTotalBalance = $lastKardex?->total_balance ?? 0;

            $inventory = new Inventory();
            $inventory->inventoryable_type = Movements::class;
            $inventory->inventoryable_id = $movement->id;
            $inventory->product_id = $product['id'];
            $inventory->warehouse_id = $this->warehouse_id;
            $inventory->detail = 'Movimiento';
            
            if ($this->type == 1) {
                $newQuantityBalance = $lastQuantityBalance + $product['quantity'];
                $newTotalBalance = $lastTotalBalance + ($product['quantity'] * $product['price']);

                $inventory->quantity_in = $product['quantity'];
                $inventory->cost_in = $product['price'];
                $inventory->total_in = $product['quantity'] * $product['price'];
            } elseif ($this->type == 2) {
                $newQuantityBalance = $lastQuantityBalance - $product['quantity'];
                $newTotalBalance = $lastTotalBalance - ($product['quantity'] * $product['price']);
                
                $inventory->quantity_out = $product['quantity'];
                $inventory->cost_out = $product['price'];
                $inventory->total_out = $product['quantity'] * $product['price'];
            }

            $inventory->quantity_balance = $newQuantityBalance;
            $inventory->cost_balance = $newTotalBalance / ($newQuantityBalance ?: 1);
            $inventory->total_balance = $newTotalBalance;

            $inventory->save();
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Movimiento creado correctamente'
        ]);

        return redirect()->route('admin.movements.index');
    }

    public function render()
    {
        return view('livewire.admin.movement-create');
    }
}