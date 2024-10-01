<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class StoreOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('owner');
        $method = $this->getMethod();


        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:' . User::class . ($method == 'PUT' ? ',username,' . $id : ''),
        ];

        if ($method == 'POST') {
            $passwordRules = ['required', 'confirmed', Rules\Password::defaults()];
            $rules['password'] = $passwordRules;
            $rules['password_confirmation'] = 'required';
            $rules['role'] = 'required|string|max:255';
        } else {
            $rules['password'] = ['nullable', 'confirmed', Rules\Password::defaults()];
            $rules['password_confirmation'] = 'nullable';
            $rules['role'] = 'nullable|string|max:255';
        }

        return $rules;
    }
}
