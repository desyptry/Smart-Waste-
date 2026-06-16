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
        $rules = [
            'name' => 'required|string|max:100|unique:waste_categories,name,' . $this->route('kategori'),
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            // update: photo tidak wajib
            $rules['photo'] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
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