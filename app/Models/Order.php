<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_DONE = 'done';
    const STATUS_CANCEL = 'cancel';

    use HasFactory;

    protected $table = 'order';

    protected $fillable = [
        'address',
        'country',
        'city',
        'state',
        'postcode',
        'phone',
        'note',
        'total',
        'status',
        'user_id'
    ];

    public function products(){
        return $this->hasMany(OrderProduct::class,'order_id');
    }
}
