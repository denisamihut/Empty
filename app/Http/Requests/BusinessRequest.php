<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|numeric',
            'address' => 'required|max:255',
            'city' => 'nullable|max:255',
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
            'name.required' => 'El campo Nombre es obligatorio.',
            'name.max' => 'El campo Nombre no debe ser mayor a 255 caracteres.',
            'email.email' => 'El campo Email debe ser un email válido.',
            'email.max' => 'El campo Email no debe ser mayor a 255 caracteres.',
            'phone.numeric' => 'El campo Teléfono debe ser numérico.',
            'address.required' => 'El campo Dirección es obligatorio.',
            'address.max' => 'El campo Dirección no debe ser mayor a 255 caracteres.',
            'city.max' => 'El campo Ciudad no debe ser mayor a 255 caracteres.',
        ];
    }

    /**
     * Get the sanitized data from the request.
     *
     * @return array<string, mixed>
     */

    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'email' => 'trim|escape|lowercase',
            'phone' => 'trim|escape',
            'address' => 'trim|escape|uppercase',
            'city' => 'trim|escape|uppercase',
        ];
    }
}