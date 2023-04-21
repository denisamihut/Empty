<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules =  [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->id,
            'password' => 'required|string|min:6',
            'people_id' => 'nullable|integer',
            'branch_id' => 'required|array',
            'usertype_id' => 'required|integer',
            'cashbox_id' => 'required|integer',
        ];

        if ($this->method() == 'PUT') {
            $rules['password'] = 'nullable|string|min:6';
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser un email válido',
            'email.unique' => 'El email ya se encuentra registrado',
            'password.required' => 'El campo contraseña es obligatorio',
            'password.min' => 'El campo contraseña debe tener al menos 6 caracteres',
            'branch_id.required' => 'El campo sucursal es obligatorio',
            'usertype_id.required' => 'El campo tipo de usuario es obligatorio',
            'cashbox_id.required' => 'El campo Caja es obligatorio',
        ];
    }
}