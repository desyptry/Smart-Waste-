<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WasteDepositRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'drop_off_point_id' => 'required|exists:drop_off_points,id',
            'waste_category_id' => 'required|exists:waste_categories,id',
            'pickup_schedule_id' => 'nullable|exists:pickup_schedules,id',
            'weight_kg' => 'required|numeric|min:0.1',
        ];
    }
}