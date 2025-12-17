<?php

namespace App\Livewire\Admin;

use App\Facades\Kardex;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Sale;
use App\Services\KardexServices;
use Livewire\Component;

class SaleCreate extends Component
{
    public $voucher_type = 1;
    public $serie = 'F001';
    public $correlative;
    public $date;
    public $quote_id;
    public $customer_id;
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

    //Nos sirve para traer el numero de correlativo de dicha venta
    public function mount() {
        $this->correlative = Sale::max('correlative') + 1;
    }

    //Nos sirve para traer el cliente y los productos asociados a dicho cliente por medio de la cotización
    public function updated($property, $value) {
        if ($property == 'quote_id') {
            $quote = Quote::find($value);
            if ($quote) {
                $this->voucher_type = $quote->voucher_type;
                $this->customer_id = $quote->customer_id;
                $this->products = $quote->product->map(function($product) {
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
            'price' => $product->price,
            'subtotal' => $product->price
        ];
        $this->reset('product_id');
    }

    //Guardar data 
    public function save() {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'serie' => 'required|string|max:10',
            'correlative' => 'required|numeric',
            'date' => 'nullable|date',
            'quote_id' => 'nullable|exists:quotes,id',
            'customer_id' => 'required|exists:customers,id',
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
            'customer_id' => 'cliente',
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

        $sale = Sale::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $final_Date,
            'quote_id' => $this->quote_id,
            'customer_id' => $this->customer_id,
            'warehouse_id' => $this->warehouse_id,
            'total' => $this->total,
            'observation' => $this->observation
        ]);

        foreach ($this->products as $product) {
            $sale->product()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);

            //Kardex
            Kardex::registerExit($sale, $product, $this->warehouse_id, 'Venta');
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'La venta se realizo con exito!'
        ]);

        return redirect()->route('admin.sales.index');
    }

    public function render()
    {
        return view('livewire.admin.sale-create');
    }
}