<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'image',
        'price',
        'star',
        'price_sale',
        'product_type_id',
        'status'
    ];

    public $translatable = ['name'];

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
}
