<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:5000',
            'description_en' => 'nullable|string|max:5000',
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
            'name_ar.required' => __('admin.validation.category.name_required'),
            'name_ar.string' => __('admin.validation.category.name_string'),
            'name_ar.max' => __('admin.validation.category.name_max'),
            'name_en.required' => __('admin.validation.category.name_required'),
            'name_en.string' => __('admin.validation.category.name_string'),
            'name_en.max' => __('admin.validation.category.name_max'),
            'image.image' => __('admin.validation.category.image_image'),
            'image.mimes' => __('admin.validation.category.image_mimes'),
            'image.max' => __('admin.validation.category.image_max'),
        ];
    }
}
