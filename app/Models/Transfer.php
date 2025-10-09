<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'type',
        'serie',
        'correlative',
        'date',
        'total',
        'observation',
        'origin_warehouse_id',
        'destination_warehouse_id'
    ];

    //Relación uno a muchos inversa
    public function origin_warehouse(){
        return $this->belongsTo(Warehouse::class, 'origin_warehouse_id');
    }

    //Relación uno a muchos inversa
    public function destination_warehouse(){
        return $this->belongsTo(Warehouse::class, 'destination_warehouse_id');
    }

    //Relación muchos a muchos
    public function product(){
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }
}
