<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KasMasukRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->filled('amount')) {
            $this->merge([
                'amount' => preg_replace('/[^0-9]/', '', $this->amount),
            ]);
        }
        if ($this->filled('price')) {
            $this->merge([
                'price' => preg_replace('/[^0-9]/', '', $this->price),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'category_id' => 'required_without:product_id|nullable|exists:categories,id',
            'account_id' => 'nullable|exists:akun_coa,id',
            'payment_account_id' => 'nullable|exists:akun_coa,id',
            'product_id' => 'required_without:category_id|nullable|exists:products,id',
            'quantity' => 'nullable|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'amount' => 'required|numeric|min:0.01',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Tanggal harus diisi',
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'amount.required' => 'Jumlah harus diisi',
            'amount.numeric' => 'Jumlah harus berupa angka',
            'file.mimes' => 'Format file harus jpeg, png, jpg, atau pdf',
            'file.max' => 'Ukuran file maksimal 2MB',
        ];
    }
}
