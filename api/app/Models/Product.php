<?php

namespace App\Models;

use App\Enums\ProductStatusEnum;
use App\Models\Builders\ProductBuilder;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property ProductStatusEnum $status
 * @property float $price
 * @property int $stock
 * @property string $ean_13
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static ProductBuilder|Product applyFilters(\Illuminate\Http\Request $request)
 * @method static ProductBuilder|Product byEan($code)
 * @method static ProductBuilder|Product byIds($ids)
 * @method static ProductBuilder|Product byName($name)
 * @method static ProductBuilder|Product byPrice($price)
 * @method static ProductBuilder|Product byStock($stock)
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static ProductBuilder|Product newModelQuery()
 * @method static ProductBuilder|Product newQuery()
 * @method static ProductBuilder|Product orderBys(\Illuminate\Http\Request $request)
 * @method static ProductBuilder|Product pagination($limit = 15)
 * @method static ProductBuilder|Product query()
 * @method static ProductBuilder|Product s(string $input)
 * @method static ProductBuilder|Product statuses($status)
 * @method static ProductBuilder|Product whereCreatedAt($value)
 * @method static ProductBuilder|Product whereEan13($value)
 * @method static ProductBuilder|Product whereId($value)
 * @method static ProductBuilder|Product whereName($value)
 * @method static ProductBuilder|Product wherePrice($value)
 * @method static ProductBuilder|Product whereStatus($value)
 * @method static ProductBuilder|Product whereStock($value)
 * @method static ProductBuilder|Product whereUpdatedAt($value)
 * @method static ProductBuilder|Product whereUserId($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    /**  @use HasFactory<ProductFactory> */
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Product>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
