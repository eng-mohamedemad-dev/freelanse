<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('admin.validation.category.name_required'),
            'name.max' => __('admin.validation.category.name_max'),
            'description.required' => __('admin.validation.category.description_required'),
            'description.max' => __('admin.validation.category.description_max'),
            'image.image' => __('admin.validation.category.image_image'),
            'image.mimes' => __('admin.validation.category.image_mimes'),
            'image.max' => __('admin.validation.category.image_max'),
        ];
    }
}
