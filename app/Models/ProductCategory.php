<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $tables = 'product_categories';

    protected $fillable = [
        'name'
    ];

    public function getProducts(){
        return $this->hasMany(Product::class, 'category_id');
    }
}
