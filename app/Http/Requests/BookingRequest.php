<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
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
            'datefrom' => 'required|date',
            'dateto' => 'required|date',
            'room_id' => 'required|integer',
            'amount' => 'required|decimal',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'datefrom.required' => 'El campo fecha desde es obligatorio',
            'datefrom.date' => 'El campo fecha desde debe ser una fecha válida',
            'dateto.required' => 'El campo fecha hasta es obligatorio',
            'dateto.date' => 'El campo fecha hasta debe ser una fecha válida',
            'room_id.required' => 'El campo habitación es obligatorio',
            'room_id.integer' => 'El campo habitación debe ser un número entero',
            'amount.required' => 'El campo monto es obligatorio',
            'amount.decimal' => 'El campo monto debe ser un número decimal',
            'notes.string' => 'El campo notas debe ser una cadena de caracteres',
        ];
    }
}