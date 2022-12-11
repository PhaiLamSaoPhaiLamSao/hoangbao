<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $table = 'order_product';

    protected $fillable = [
        'name',
        'qty',
        'price',
        'total',
        'order_id'
    ];
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
