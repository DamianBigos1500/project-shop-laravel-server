<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdateUserAdminRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     *             
     * @throws \JsonException
     */
    protected function prepareForValidation(): void
    {
        $this->merge(json_decode($this->payload, true, 512, JSON_THROW_ON_ERROR));
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'surname' => ['sometimes', 'nullable', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'string', 'email', 'max:255'],
            'phone_number' => ['sometimes', 'nullable',],
            'role' => ['required'],
            'password' => ['sometimes', 'nullable', 'confirmed', Rules\Password::defaults()],
            'profile_image' => ['sometimes', 'nullable'],
            'profile_image.*' => ['mimes:jpg,jpeg,png,bmp', 'max:20000']
        ];
    }
}
