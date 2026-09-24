<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'sub_category_id' => ['required'],
            'title' => ['required', 'string', 'max:500'],
            'description' => ['required'],
            'price' => ['required', 'min:1'],

            'province_id' => ['required', 'numeric', 'exists:provinces,id'],
            'district_id' => ['required', 'numeric', 'exists:districts,id'],
        ];
    }
}
