<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'variants' => 'nullable|array',
            'variants.*.size_id' => 'nullable|exists:sizes,id',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.images' => 'nullable|array',
            'variants.*.images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
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
            'name_ar.required' => __('admin.validation.product.name_required'),
            'name_ar.max' => __('admin.validation.product.name_max'),
            'name_en.required' => __('admin.validation.product.name_required'),
            'name_en.max' => __('admin.validation.product.name_max'),
            'category_id.required' => __('admin.validation.product.category_id_required'),
            'category_id.exists' => __('admin.validation.product.category_id_exists'),
            'images.*.image' => __('admin.validation.product.images_image'),
            'images.*.mimes' => __('admin.validation.product.images_mimes'),
            'images.*.max' => __('admin.validation.product.images_max'),
            'price.required' => __('admin.validation.product.price_required'),
            'price.numeric' => __('admin.validation.product.price_numeric'),
            'price.min' => __('admin.validation.product.price_min'),
            'sale_price.numeric' => __('admin.validation.product.sale_price_numeric'),
            'sale_price.min' => __('admin.validation.product.sale_price_min'),
            'stock.required' => __('admin.validation.product.stock_required'),
            'stock.integer' => __('admin.validation.product.stock_integer'),
            'stock.min' => __('admin.validation.product.stock_min'),
        ];
    }
}
