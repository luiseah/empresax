<?php

namespace App\Http\Requests;

use App\Enums\ProductStatusEnum;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            's' => ['string'],
            'stock' => ['integer'],
            'price' => ['numeric'],
            'ean' => ['string'],

            'statuses' => ['array', 'min:1'],
            'statuses.*' => [Rule::enum(ProductStatusEnum::class)],

            'ids' => ['array', 'min:1'],
            'ids.*' => [Rule::exists(Product::class, 'id')],

            'orderBys' => ['sometimes', 'array'],
            'orderBys.*' => ['string', Rule::in('asc', 'desc')],

            'per_page' => ['integer', 'min:10', 'max:25'],
        ];
    }
}
