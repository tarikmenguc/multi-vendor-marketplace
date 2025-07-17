<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'shipping_address' => 'required|array',
            'shipping_address.name' => 'required|string|max:100',
            'shipping_address.phone' => 'required|string|max:20',
            'shipping_address.city' => 'required|string|max:50',
            'shipping_address.address' => 'required|string|max:255',
        ];
    }
}
