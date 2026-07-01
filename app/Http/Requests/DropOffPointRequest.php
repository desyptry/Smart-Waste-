<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropOffPointRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'assesor_id' => 'nullable|exists:users,id',
            'officer_ids' => 'nullable|array',
            'officer_ids.*' => 'exists:users,id',
        ];
    }
}