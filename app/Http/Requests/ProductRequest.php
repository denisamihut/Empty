<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    use SanitizesInput;
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'sale_price' => 'required|numeric',
            'purchase_price' => 'required|numeric',
            'category_id' => 'required',
            'unit_id' => 'required',
            'branch_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'sale_price.required' => 'El campo precio de venta es obligatorio',
            'sale_price.numeric' => 'El campo precio de venta debe ser un número',
            'purchase_price.required' => 'El campo precio de compra es obligatorio',
            'purchase_price.numeric' => 'El campo precio de compra debe ser un número',
            'category_id.required' => 'El campo categoria es obligatorio',
            'unit_id.required' => 'El campo unidad es obligatorio',
            'branch_id.required' => 'El campo sucursal es obligatorio',
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'sale_price' => 'trim|escape|uppercase',
            'purchase_price' => 'trim|escape|uppercase',
            'category_id' => 'trim|escape|uppercase',
            'unit_id' => 'trim|escape|uppercase',
            'branch_id' => 'trim|escape|uppercase',
        ];
    }
}