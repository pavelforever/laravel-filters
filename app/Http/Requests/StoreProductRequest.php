<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'fileName' => 'required|file|mimes:pdf,zip,png',
            'published' => 'boolean',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'nullable|integer|exists:categories,id',
        ];
    }
}
