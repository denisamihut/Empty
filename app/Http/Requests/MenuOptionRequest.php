<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class MenuOptionRequest extends FormRequest
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
            'link' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'order' => 'nullable|integer',
            'menugroup_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'name.string' => 'El campo nombre debe ser texto',
            'name.max' => 'El campo nombre debe tener máximo 255 caracteres',
            'link.required' => 'El campo link es obligatorio',
            'link.string' => 'El campo link debe ser texto',
            'link.max' => 'El campo link debe tener máximo 255 caracteres',
            'icon.required' => 'El campo icono es obligatorio',
            'icon.string' => 'El campo icono debe ser texto',
            'icon.max' => 'El campo icono debe tener máximo 255 caracteres',
            'order.integer' => 'El campo orden debe ser un número entero',
            'menugroup_id.required' => 'El campo grupo de menú es obligatorio',
        ];
    }

    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'link' => 'trim|escape|uppercase',
            'icon' => 'trim|escape|uppercase',
            'order' => 'trim|escape|uppercase',
            'menugroup_id' => 'trim|escape|uppercase',
        ];
    }
}