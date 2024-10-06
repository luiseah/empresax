<?php

namespace App\Models\Builders;

use App\Enums\ProductStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @extends Builder<\App\Models\Product>
 */
class ProductBuilder extends Builder
{
    /**
     *
     * @param int $limit
     * @return mixed
     */
    public function pagination(int $limit = 15): mixed
    {
        return \Request::has('per_page')
            ? $this->paginate(\Request::integer('per_page', $limit))
            : $this->get();
    }

    /**
     * @param string $input
     * @return $this
     */
    public function s(string $input): static
    {
        $this->where(fn(ProductBuilder $q) => $q
            ->orWhere(fn(ProductBuilder $q) => $q->byName($input)));

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function byName(string $name): static
    {
        $this->whereRaw('s(name) LIKE s(?)', [s($name)]);

        return $this;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function byPrice(float $price): static
    {
        $this->where('price', $price);

        return $this;
    }

    /**
     * @param int $stock
     * @return $this
     */
    public function byStock(int $stock): static
    {
        $this->where('stock', $stock);

        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function byEan(string $code): static
    {
        $this->whereIn('ean_13', $code);

        return $this;
    }

    /**
     * @param Collection<int, int> $ids
     * @return $this
     */
    public function byIds(Collection $ids): static
    {
        $this->find($ids);

        return $this;
    }

    /**
     * @param Collection<int, ProductStatusEnum> $status
     * @return $this
     */
    public function statuses(Collection $status): static
    {
        $this->whereIn('status', $status);

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function orderBys(Request $request): static
    {
        $orders = $request->input('orderBys', [
            'created_at' => 'desc',
        ]);

        /** @var array<string, string> $orders */
        foreach ($orders as $name => $value) {
            match ($name) {
                'name' => $this->orderBy(\DB::raw('lower(name)'), $value),
                'created_at' => $this->orderBy('created_at', $value),
                'updated_at' => $this->orderBy('updated_at', $value),
                default => null,
            };
        }

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function applyFilters(Request $request): static
    {
        if ($request->has('s')) {
            $this->s($request->str('s'));
        }

        if ($request->has('name')) {
            $this->byPrice($request->float('name'));
        }

        if ($request->has('price')) {
            $this->byPrice($request->float('price'));
        }

        if ($request->has('stock')) {
            $this->byStock($request->integer('stock'));
        }

        if ($request->has('ean')) {
            $this->byEan($request->str('ean'));
        }

        if ($request->has('ids')) {
            $this->byIds($request->collect('ids'));
        }

        if ($request->has('statuses')) {
            $this->statuses($request->collect('statuses'));
        }

        $this->orderBys($request);

        return $this;
    }
}
