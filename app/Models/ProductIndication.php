<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIndication extends Model
{
    use HasFactory;

    protected $table = 'product_indication';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'indication_id',
        'description',
    ];

    public $timestamps = false;

    public function indication()
    {
        return $this->belongsToMany(Indication::class);
    }

}
