<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickupScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        $user = $this->user();
        return $user && in_array($user->role, ['admin', 'officer']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'drop_off_point_id' => 'required|exists:drop_off_points,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'status' => 'nullable|in:akan_datang,selesai',
        ];
    }

  
    public function messages(): array
    {
        return [
            'drop_off_point_id.required' => 'Posko wajib dipilih.',
            'drop_off_point_id.exists' => 'Posko tidak valid.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.after_or_equal' => 'Tanggal tidak boleh kurang dari hari ini.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu selesai wajib diisi.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ];
    }
}