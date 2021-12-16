<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id ',
        'product_id',
        'quantity',
        'price',
        'subtotal'
    ];

    public $timestamps = false;

    public function orders()
    {
        return $this->belongsTo(Order::class);
    }

    public function product_option()
    {
        return $this->hasMany(OrderProductOption::class);
    }
}
