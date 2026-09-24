<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class   IdeaRequest extends FormRequest
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
            'category_id' => ['nullable', 'exists:categories,id'],
            'content' => ['required', 'string'],
            'path' => ['nullable'],
            'path.*' => ['required', 'file', 'mimes:jpg,jpeg,png,mp4', 'max:5120'],
            'status' => ['required', 'boolean'],
        ];
    }
}
