<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HandleCallbackSecondRequest extends FormRequest
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
            'project' => ['required', 'integer', 'in:'.env('APP_PAYMENT_ID')],
            'invoice' => ['required', 'integer'],
            'status' => ['required', 'in:created,inprogress,paid,expired,rejected'],
            'amount' => ['required', 'numeric'],
            'amount_paid' => ['required', 'numeric'],
            'rand' => ['required', 'string'],
        ];
    }
}
