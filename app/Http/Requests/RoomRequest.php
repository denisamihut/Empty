<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'number' => 'required',
            'status' => 'required',
            'room_type_id' => 'required',
            'floor_id' => 'required',
            'branch_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'number.required' => 'El campo número es obligatorio',
            'status.required' => 'El campo estado es obligatorio',
            'room_type_id.required' => 'El campo tipo de habitación es obligatorio',
            'floor_id.required' => 'El campo piso es obligatorio',
            'branch_id.required' => 'El campo sucursal es obligatorio',
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'number' => 'trim|escape|uppercase',
            'status' => 'trim|escape|uppercase',
            'room_type_id' => 'trim|escape|uppercase',
            'floor_id' => 'trim|escape|uppercase',
            'branch_id' => 'trim|escape|uppercase',
        ];
    }
}