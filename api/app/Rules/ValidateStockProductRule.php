<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class ValidateStockProductRule implements ValidationRule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string, mixed>
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $replace = Str::of($attribute)->replace('quantity', 'product_id');
        $product = data_get($this->data, $replace);

        /**
         * @var \App\Models\Product $product
         */
        $product = Product::findOrFail($product);

        if ($product->stock < $value) {
            $fail("The product {$product->name} does not have enough stock.");
        }
    }
}
