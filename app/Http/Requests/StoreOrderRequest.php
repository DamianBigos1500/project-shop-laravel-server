<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ["required", 'min:3', 'max:255'],
            'surname' => ["required", 'min:3', 'max:255'],
            'email' => ["required", 'email'],
            'telephone' => ["required", "numeric"],
            'street' => ["required", 'min:3', 'max:255'],
            'address' => ["required",'max:255'],
            'city' => ["required", 'min:3', 'max:255'],
            'zip_code' => ["required", 'min:3', 'max:255'],
        ];
    }
}
