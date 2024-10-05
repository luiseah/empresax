<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Return
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasBelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Product::class, 'cart_items')
            ->using(CartItem::class)
            ->withPivot('quantity', 'subtotal', 'iva')
            ->withTimestamps();
    }
}
