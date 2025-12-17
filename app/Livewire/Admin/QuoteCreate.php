<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Quote;
use Livewire\Component;

class QuoteCreate extends Component
{
    public $voucher_type = 1;
    public $serie = "D001";
    public $correlative;
    public $date;
    public $customer_id;
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
        $this->correlative = Quote::max('correlative') + 1;
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
            'price' => $product->price,
            'subtotal' => $product->price
        ];
        $this->reset('product_id');
    }

    public function save() {
        $this->validate([
            'voucher_type' => 'required|in:1,2',
            'date' => 'nullable|date',
            'customer_id' => 'required|exists:customers,id',
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

        $quote = Quote::create([
            'voucher_type' => $this->voucher_type,
            'serie' => $this->serie,
            'correlative' => $this->correlative,
            'date' => $final_Date,
            'customer_id' => $this->customer_id,
            'total' => $this->total,
            'observation' => $this->observation
        ]);

        foreach ($this->products as $product) {
            $quote->product()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
                'subtotal' => $product['quantity'] * $product['price'],
            ]);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => '¡Bien hecho!',
            'text' => 'Cotización creada correctamente'
        ]);

        return redirect()->route('admin.quotes.index');
    }

    public function render()
    {
        return view('livewire.admin.quote-create');
    }
}