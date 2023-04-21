<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class CashRegisterRequest extends FormRequest
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
            'concept_id' => 'required|integer',
            'amount' => 'required|numeric',
            'notes' => 'nullable|string',
            'client_id' => 'nullable|integer',
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
            'concept_id.required' => 'El concepto es requerido',
            'concept_id.integer' => 'El concepto debe ser un número entero',
            'amount.required' => 'El monto es requerido',
            'amount.numeric' => 'El monto debe ser un número',
            'notes.string' => 'Las notas deben ser un texto',
            'client_id.integer' => 'El cliente debe ser un número entero',
        ];
    }

    /**
     * Get the filters to be applied to the input.
     *
     * @return array<string, mixed>
     */
    public function filters()
    {
        return [
            'date' => 'trim|escape|strip_tags',
            'number' => 'trim|escape|strip_tags',
            'concept_id' => 'trim|escape|strip_tags',
            'amount' => 'trim|escape|strip_tags',
            'notes' => 'trim|escape|strip_tags|uppercase',
            'client_id' => 'trim|escape|strip_tags',
        ];
    }
}