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
            'name' => 'required|string|max:255',
            'wood_type' => 'nullable|string|max:100',
            'product_category' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
            'cubic_content' => 'nullable|integer|min:0',
            'unit' => 'required|string|max:50',
            'cost' => 'required|numeric|min:0',
            'stock' => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk harus diisi',
            'unit.required' => 'Satuan produk harus diisi (contoh: Ikat, Pcs, M3)',
            'cost.required' => 'Harga beli/HPP harus diisi',
            'cost.numeric' => 'Harga beli/HPP harus berupa angka',
        ];
    }
}
