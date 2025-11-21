<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movements extends Model
{
    protected $fillable = [
        'type',
        'serie',
        'correlative',
        'date',
        'warehouse_id',
        'total',
        'observation',
        'reason_id'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    //Relación uno a muchos inversa
    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }

    //Relación uno a muchos inversa
    public function reason() {
        return $this->belongsTo(Reason::class);
    }

    //Relación muchos a muchos
    public function product(){
        return $this->morphToMany(Product::class, 'productable')
            ->withPivot('quantity', 'price', 'subtotal')
            ->withTimestamps();
    }
}