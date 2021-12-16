<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id ',
        'code',
        'total',
        'discount',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }
    
    public function order_payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function order_status()
    {
        return $this->hasMany(OrderStatus::class);
    }
}
