<?php

namespace App\Livewire\Admin;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Services\KardexServices;
use Livewire\Component;

class PurchaseCreate extends Component
{
    public $voucher_type = 1;
    public $serie;
    public $correlative;
    public $date;
    public $purchase_order_id;
    public $supplier_id;
    public $warehouse_id;
    public $total = 0;
    public $observation;
    public $product_id;
    public $products = [];

    //Validar si hay error por no haber seleccionado un producto
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

    //Nos sirve para traer al provedor y los productos por medio de la orden de compra
    public function updated($property, $value) {
        if ($property == 'purchase_order_id') {
            $purchaseOrder = PurchaseOrder::find($value);
            if ($purchaseOrder) {
                $this->voucher_type = $purchaseOrder->voucher_type;
                $this->supplier_id = $purchaseOrder->supplier_id;
            
                $this->products = $purchaseOrder->product->map(function($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'quantity' => $product->pivot->quantity,
                        'price' => $product->pivot->price,
                        'subtotal' => $product->pivot->subtotal
                    ];
                })->toArray();
            }
        }
    }

    //Agregar producto a la tabla
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
        $lastKardex = Kardex::getLastKardex($product->id, $this->warehouse_id);

        $this->products[] = [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => 1,
            'price' => $lastKardex['cost'],
            'subtotal' => $lastKardex['cost']
        ];
        $this->reset('product_id');
    }

    //Guardar data 
    public function save() {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|string|max:10',
            'date' => 'nullable|date',
            'purchase_order_id' => 'nullable|exists:purchase_orders,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
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

        $purchase_Date = $this->date;
        $final_Date = now();
        if (!empty($purchase_Date)) {
            try {
                $carbon_Date = \Carbon\Carbon::parse($purchase_Date);
                $currentTimeString = now()->format('H:i:s');
                $final_Date = $carbon_Date->setTimeFromTimeString($currentTimeString);
            } catch (\Exception $e) {
                $final_Date = now();
            }
        }

        $purchase = Purchase::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $final_Date,
            'purchase_order_id' => $this->purchase_order_id,
            'supplier_id' => $this->supplier_id,
            'warehouse_id' => $this->warehouse_id,
            'total' => $this->total,
            'observation' => $this->observation
        ]);

        foreach ($this->products as $product) {
            $purchase->product()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            //Kardex
            Kardex::registerEntry($purchase, $product, $this->warehouse_id, 'Compra');
            
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La compra se ha creado correctamente'
        ]);

        return redirect()->route('admin.purchases.index');
    }

    public function render()
    {
        return view('livewire.admin.purchase-create');
    }
}