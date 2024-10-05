<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use App\Models\Builders\ProductBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The Eloquent query builder class to use for the model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Builder<*>>
     */
    protected static string $builder = ProductBuilder::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'price',
        'stock',
        'ean_13',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProductStatusEnum::class,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
