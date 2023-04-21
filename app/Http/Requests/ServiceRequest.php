<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'description' => 'required|max:255',
            'price' => 'required|numeric',
            'branch_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es requerido',
            'description.required' => 'El campo descripción es requerido',
            'price.required' => 'El campo precio es requerido',
            'branch_id.required' => 'El campo sucursal es requerido',
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'description' => 'trim|escape|uppercase',
            'price' => 'trim|escape|uppercase',
            'branch_id' => 'trim|escape|uppercase',
        ];
    }
}