<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class CashBoxRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'comments' => 'nullable|string|max:255',
            'branch_id' => 'required|integer|exists:branches,id',
            'business_id' => 'required|integer|exists:business,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre debe tener como máximo 100 caracteres',
            'phone.string' => 'El teléfono debe ser una cadena de texto',
            'phone.max' => 'El teléfono debe tener como máximo 20 caracteres',
            'comments.string' => 'Los comentarios deben ser una cadena de texto',
            'comments.max' => 'Los comentarios deben tener como máximo 255 caracteres',
            'branch_id.required' => 'La sucursal es requerida',
            'branch_id.integer' => 'La sucursal debe ser un número entero',
            'branch_id.exists' => 'La sucursal no existe',
            'business_id.required' => 'La empresa es requerida',
            'business_id.integer' => 'La empresa debe ser un número entero',
            'business_id.exists' => 'La empresa no existe',
        ];
    }

    /**
     * Get the filters to be applied to the data.
     *
     * @return array<string, mixed>
     */
    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'phone' => 'trim|escape|uppercase',
            'comments' => 'trim|escape|uppercase',
            'branch_id' => 'trim|escape|uppercase',
            'business_id' => 'trim|escape|uppercase',
        ];
    }
}