<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        return [
            'store_id' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date', 'after:date_start'],
            'coupon_rewards' => ['required', 'array'],
            'coupon_rewards.*.reward' => ['required', 'string'],
            'coupon_rewards.*.details' => ['nullable', 'string'],
            'coupon_rewards.*.sort' => ['required', 'integer'],
        ];
    }

     /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'coupon_rewards.required' => 'The reward details need to fill at least 1.',
            'coupon_rewards.*.reward.required' => 'The reward title field is required.',
            'coupon_rewards.*.reward.string' => 'The reward title must be a string.',
            'coupon_rewards.*.details.string' => 'The reward details must be a string.',
            'coupon_rewards.*.sort.required' => 'The reward sort order is required.',
            'coupon_rewards.*.sort.integer' => 'The reward sort order must be an integer.',
        ];
    }
}
