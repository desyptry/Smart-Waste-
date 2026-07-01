<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WasteDepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.waste_price_id' => 'required|exists:schedule_prices,id',
            'items.*.weight_kg' => 'required|numeric|min:0.01',
            'items.*.total_price' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Nama nasabah wajib dipilih.',
            'items.required' => 'Minimal harus ada 1 item sampah yang ditimbang.',
            'items.*.waste_price_id.required' => 'Komoditas sampah harus dipilih.',
            'items.*.weight_kg.required' => 'Berat timbangan wajib diisi.',
            'items.*.weight_kg.min' => 'Berat timbangan minimal 0.01 Kg.',
        ];
    }
}
