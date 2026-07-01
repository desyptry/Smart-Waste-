<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Atur sesuai permission nanti
    }

    public function rules()
    {
        // $userId = $this->route('user') ? $this->route('user')->id : null;
        $user = $this->route('user');
        $userId = is_object($user) ? $user->id : $user;
        return [
            'name' => 'required|string|max:255',
            // 'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($userId)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($userId)],
            'password' => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
            // 'role' => ['required', Rule::in(['admin', 'officer', 'resident'])],
            // 'balance' => 'nullable|numeric|min:0',
            'role' => ['required', Rule::in(['admin', 'officer', 'citizen', 'assesor'])],
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:15',
            'status' => 'nullable|in:active,inactive,banned',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            // 'username.unique' => 'Username sudah digunakan.',
             'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role yang dipilih tidak valid.',
        ];
    }
}