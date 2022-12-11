<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $tables = 'products';

    protected $fillable = [
        'name',
        'price',
        'image',
        'des',
        'qty',
        'weight',
        'category_id',
        'slug'
    ];

    public function getCategory(){
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
