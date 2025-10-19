<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'location'
    ];

    //Relación uno a muchos
    public function inventories() {
        return $this->hasMany(Inventory::class);
    }
}
