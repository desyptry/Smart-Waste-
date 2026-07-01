<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickupScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sudah diatur agar bisa diupload bebas
    }

    public function rules(): array
    {
        return [
            // Sesuaikan dengan nama atribut 'name' di form HTML Anda
            'collection_point_id' => 'required',
            'start_date'          => 'required|date',
            'finish_date'         => 'required|date|after:start_date',
        ];
    }

    public function messages(): array
    {
        return [
            'collection_point_id.required' => 'Titik kumpul/Posko wajib dipilih.',
            'start_date.required'          => 'Waktu mulai wajib diisi.',
            'start_date.date'              => 'Format waktu mulai tidak valid.',
            'finish_date.required'         => 'Waktu selesai wajib diisi.',
            'finish_date.date'             => 'Format waktu selesai tidak valid.',
            'finish_date.after'            => 'Waktu selesai harus setelah waktu mulai.',
        ];
    }
}
