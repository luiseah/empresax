<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\ValidateStockProductRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCartRequest extends FormRequest
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
            'products' => [
                'array', 'min:1'
            ],
            'products.*.product_id' => ['bail', 'required', Rule::exists(Product::class, 'id')],
            'products.*.quantity' => ['bail', 'required', 'integer', 'min:1', new ValidateStockProductRule()],
        ];
    }
}
