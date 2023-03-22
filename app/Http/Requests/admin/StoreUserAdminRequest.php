<?php

namespace App\Http\Requests\admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use JsonException;

class StoreUserAdminRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required'],
            'role' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
