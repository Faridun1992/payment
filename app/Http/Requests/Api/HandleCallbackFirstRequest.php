<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HandleCallbackFirstRequest extends FormRequest
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
            'merchant_id' => ['required', 'integer', 'in:'.env('MERCHANT_ID')],
            'payment_id' => ['required', 'integer'],
            'status' => ['required', 'in:new,pending,completed,expired,rejected'],
            'amount' => ['required', 'numeric'],
            'amount_paid' => ['required', 'numeric'],
            'timestamp' => ['required', 'integer'],
            'sign' => ['required', 'string']
        ];
    }
}
