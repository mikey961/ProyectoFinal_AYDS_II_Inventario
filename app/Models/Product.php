<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'sku',
        'barcode',
        'price',
        'category_id',
        'stock'
    ];

    //Accesor para mostrar la imagen del producto
    protected function image(): Attribute{
        return Attribute::make(
            get: fn() => $this->images()->count() ? Storage::url($this->images()->first()->path) : 'https://dicesabajio.com.mx/wp-content/uploads/2021/06/no-image.jpeg'
        );
    }

    //Relación uno a muchos inversa
    public function category(){
        return $this->belongsTo(Category::class);
    }

    //Relación uno a muchos
    public function inventories(){
        return $this->hasMany(Inventory::class);
    }

    public function purchaseOrders(){
        return $this->morphedByMany(PurchaseOrder::class, 'productable');
    }

    public function quotes(){
        return $this->morphedByMany(Quote::class, 'productable');
    }

    //Relación polimórfica
    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            //Generar SKU solo si no ha sido proporcionado manualmente
            if (empty($product->sku)) {
                $product->sku = self::generateSKU($product);
            }
        });
    }

    protected static function generateSKU($product)
    {
        $category = Category::find($product->category_id);
        $prefix = $category ? strtoupper(substr(Str::slug($category->name), 0, 3)) : 'CAT';
        $uniqueId = strtoupper(Str::random(5));
        $generatedSKU = "{$prefix}-{$uniqueId}";

        while (Product::where('sku', $generatedSKU)->exists()) {
            $uniqueId = strtoupper(Str::random(5));
            $generatedSKU = "{$prefix}-{$uniqueId}";
        }

        return $generatedSKU;
    }
}