<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
{
    use SanitizesInput;
    protected $type;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (strlen($this->dni) == 8) {
            $this->type = 'DNI';
            $this->merge([
                'dni' => $this->dni,
                'ruc' => null,
                'social_reason' => null,
                'name' => $this->name,
            ]);
        } else if (strlen($this->dni) == 11) {
            $this->type = 'RUC';
            $this->merge([
                'dni' => null,
                'ruc' => $this->dni,
                'social_reason' => $this->name,
                'name' => null,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->type == 'DNI') {
            return [
                'dni' => 'required|digits:8|unique:people,dni,' . $this->id,
                'name' => 'required',
            ];
        } else {
            return [
                'ruc' => 'required|digits:11|unique:people,dni,' . $this->id,
                'social_reason' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'dni.digits' => 'El DNI debe tener 8 dígitos',
            'ruc.digits' => 'El RUC debe tener 11 dígitos',
            'ruc.numeric' => 'El RUC debe ser numérico',
            'ruc.required' => 'El RUC es requerido o incorrecto',
            'ruc.unique' => 'El RUC ya existe en la base de datos',
            'dni.unique' => 'El DNI ya existe en la base de datos',
            'dni.required' => 'El DNI es requerido',
            'social_reason.required' => 'La razón social es requerida o incorrecta',
        ];
    }

    public function filters()
    {
        return [
            'dni' => 'trim|escape|uppercase',
            'ruc' => 'trim|escape',
            'name' => 'trim|escape|uppercase',
            'social_reason' => 'trim|escape|uppercase',
            'address' => 'trim|escape|uppercase',
        ];
    }
}