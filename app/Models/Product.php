<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array 
     */

    protected $fillable = [
        'treatment_id',
        'category_id',
        'title',
        'short_description',
        'description',
        'image',
        'banner',
        'female',
        'male',
        'price',
        'old_price',
        'new_price',
        'discount',
        'status',
        'slug',
        'available',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class);
    }

    public function indications()
    {
        return $this->belongsToMany(ProductIndication::class, 'product_indication');
    }
}
