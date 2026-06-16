<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->filled('cost')) {
            $this->merge([
                'cost' => preg_replace('/[^0-9]/', '', $this->cost),
            ]);
        }
        if ($this->filled('stock')) {
            $this->merge([
                'stock' => str_replace(',', '.', $this->stock),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'wood_type'      => 'required|string|max:100',
            'cost'           => 'required|numeric|min:0',
            'stock'          => 'nullable|numeric|min:0',
            'products'       => 'nullable|array',
            'products.*.category'                => 'nullable|string',
            'products.*.items'                   => 'nullable|array',
            'products.*.items.*.size'            => 'nullable|string|max:100',
            'products.*.items.*.cubic_content'   => 'nullable|integer|min:0',
            'products.*.items.*.product_id'      => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'wood_type.required' => 'Jenis kayu harus diisi',
            'cost.required'      => 'Harga beli/HPP harus diisi',
        ];
    }
}
