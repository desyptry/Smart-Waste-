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
            'address' => 'required|string',
        ];
    }
}