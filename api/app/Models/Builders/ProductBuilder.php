<?php

namespace App\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;


class ProductBuilder extends Builder
{
    /**
     *
     * @return mixed
     */
    public function pagination($limit = 15)
    {
        return \Request::has('per_page')
            ? $this->paginate(\Request::integer('per_page', $limit))
            : $this->get();
    }

    /**
     * @param $input
     * @method search($input)
     *
     * @return $this
     */
    public function s($input)
    {
        $this->where(fn($q) => $q
            ->orWhereRaw('s(price) LIKE s(?)', [s($input)])
            ->orWhereRaw('s(ean_13) LIKE s(?)', [s($input)])
            ->orWhereRaw('s(stock) LIKE s(?)', [s($input)]));

        return $this;
    }

    public function byPrice($price)
    {
        $this->where('price', $price);

        return $this;
    }

    public function byStock($stock)
    {
        $this->where('stock', $stock);

        return $this;
    }

    public function byEan($code)
    {
        $this->where('ean_13', $code);

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function orderBys(Request $request)
    {
        $orders = $request->input('orderBys', [
            'created_at' => 'desc',
        ]);

        foreach ($orders as $name => $value) {
            match ($name) {
                'name' => $this->orderBy(\DB::raw('lower(name)'), $value),
                'created_at' => $this->orderBy('created_at', $value),
                'updated_at' => $this->orderBy('updated_at', $value),
            };
        }

        return $this;
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function applyFilters(Request $request)
    {
        if ($request->has('s')) {
            $this->s($request->str('s'));
        }

        if ($request->has('price')) {
            $this->byPrice($request->float('price'));
        }

        if ($request->has('stock')) {
            $this->byStock($request->float('stock'));
        }

        if ($request->has('ean')) {
            $this->byEan($request->float('ean'));
        }

        $this->orderBys($request);

        return $this;
    }
}
