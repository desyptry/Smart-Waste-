<?php

namespace App\Http\Requests\Officer;

use Illuminate\Foundation\Http\FormRequest;

class SchedulePriceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Diatur bebas akses/bypass role sementara
    }

    public function rules(): array
    {
        return [
            'prices' => 'required|array',
            'prices.*' => 'required|numeric|min:0', // Validasi setiap input nominal harga
        ];
    }

    public function messages(): array
    {
        return [
            'prices.*.required' => 'Nominal harga wajib diisi.',
            'prices.*.numeric'  => 'Nominal harga harus berupa angka.',
            'prices.*.min'      => 'Nominal harga tidak boleh minus.',
        ];
    }
}
