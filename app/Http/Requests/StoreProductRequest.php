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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
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
            'name.required' => __('admin.validation.product.name_required'),
            'name.max' => __('admin.validation.product.name_max'),
            'description.required' => __('admin.validation.product.description_required'),
            'category_id.required' => __('admin.validation.product.category_id_required'),
            'category_id.exists' => __('admin.validation.product.category_id_exists'),
            'images.required' => __('admin.validation.product.images_required'),
            'images.min' => __('admin.validation.product.images_min'),
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
