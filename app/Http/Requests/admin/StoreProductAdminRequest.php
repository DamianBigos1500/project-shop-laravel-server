<?php

namespace App\Http\Requests\admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role === UserRole::ADMIN;
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
            'category_id' => ['required', 'integer', 'min:0', 'max:20000'],
            'product_code' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:1024'],
            'long_description' => ['required', 'string', 'max:2048'],
            'regular_price' => ['required', "max:2000000"],
            'discount_price' => ['max:2000000'],
            'is_available' => ['required', 'boolean', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0', 'max:2000000'],
            'images' => ['required'],
            'images.*' => ['mimes:jpg,jpeg,png,bmp', 'max:20000']
        ];
    }
}
