<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\PurchaseOrder;
use Livewire\Component;

class PurchaseOrdersCreate extends Component
{
    public $voucher_type = 1;
    public $serie = "OS10";
    public $correlative;
    public $date;
    public $supplier_id;
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
        $this->correlative = PurchaseOrder::max('correlative') + 1;
    }

    public function addProduct() {
        $this->validate([
            'product_id' => 'required|exists:products,id'
        ],[],[
            'product_id' => 'producto'
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
        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0
        ];
        $this->reset('product_id');
    }

    public function save() {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'total' => 'required|numeric|min:0',
            'observation' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ],[],[
            'voucher_type' => 'tipo de comprobante',
            'date' => 'fecha',
            'supplier_id' => 'proveedor',
            'total' => 'total',
            'observation' => 'observación',
            'products' => 'productos',
            'products.*.id' => 'producto',
            'products.*.quantity' => 'cantidad',
            'products.*.price' => 'precio',
        ]);

        $purchaseOrder = PurchaseOrder::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $this->date ?? now(),
            'supplier_id' => $this->supplier_id,
            'total' => $this->total,
            'observation' => $this->observation
        ]);

        foreach ($this->products as $product) {
            $purchaseOrder->product()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Orden de compra creada correctamente'
        ]);

        return redirect()->route('admin.purchase-orders.index');
    }

    public function render()
    {
        return view('livewire.admin.purchase-orders-create');
    }
}