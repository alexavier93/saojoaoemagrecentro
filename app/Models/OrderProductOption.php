<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductOption extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_product_id ',
        'option',
    ];

    public $timestamps = false;

    public function order_product()
    {
        return $this->belongsTo(Customer::class, 'order_product');
    }
}
