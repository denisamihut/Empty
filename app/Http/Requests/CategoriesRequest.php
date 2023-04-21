<?php

namespace App\Http\Requests;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'branch_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio',
            'branch_id.required' => 'El campo sucursal es obligatorio',
        ];
    }
    public function filters()
    {
        return [
            'name' => 'trim|escape|uppercase',
            'branch_id' => 'trim|escape|uppercase',
        ];
    }


}
