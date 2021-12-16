<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{
    use HasFactory;

    protected $table = 'product_section';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'section_id',
        'price',
    ];

    public $timestamps = false;

    public function section()
    {
        return $this->belongsToMany(Section::class);
    }
}
