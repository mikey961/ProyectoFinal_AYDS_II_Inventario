<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'voucher_type',
        'serie',
        'correlative',
        'date',
        'purchase_order_id',
        'supplier_id',        
        'warehouse_id',
        'total',
        'observation'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    //Relacion uno a muchos inversa
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }


    //Relación muchos a muchos
    public function product(){
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }

    //Relación uno a muchos polimorfica
    public function inventories() {
        return $this->morphMany(Inventory::class, 'inventoryable');
    }
}
