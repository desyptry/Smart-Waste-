<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:20000',
            'method' => 'required|in:bank_transfer,e_wallet',
            'account_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
        ];
    }
}