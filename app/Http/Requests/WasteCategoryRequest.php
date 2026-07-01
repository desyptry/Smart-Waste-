<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WasteCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // atau cek role admin
    }

    public function rules()
{
    // Ambil ID dari route model binding 'wasteCategory'
    // Jika di route kamu pakai nama lain (misal: 'kategori'), sesuaikan namanya.
    $categoryId = $this->route('wasteCategory') ? $this->route('wasteCategory')->id : null;

    return [
        // Abaikan ID data saat ini agar tidak memicu error 'unique'
        'name' => 'required|string|max:100|unique:waste_categories,name,' . $categoryId,
        'description' => 'nullable|string',
        'rules' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];
}

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
        ];
    }
}