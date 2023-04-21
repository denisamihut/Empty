<?php

namespace App\Http\Requests;

use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;


class BranchRequest extends FormRequest
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
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'city' => 'nullable|string|max:255',
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
            'name.required' => 'El campo nombre es obligatorio',
            'address.required' => 'El campo dirección es obligatorio',
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
            'name' => 'trim|uppercase|escape',
            'address' => 'trim|uppercase|escape',
            'phone' => 'trim|escape',
            'email' => 'trim|escape|lowercase',
            'city' => 'trim|uppercase|escape',
        ];
    }
}
