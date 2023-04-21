<?php

namespace App\Http\Requests;

use App\Models\Payments;
use Illuminate\Foundation\Http\FormRequest;

class ManagementRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $payment_type = null;
        $payment_type_id = $this->payment_type;
        $status = 'PyNC';
        if ($this->billingToggle == 'on') {
            if ($this->payment_type == 5) {
                $payment_type = 'COMBINADO';
            } else {
                $payment = Payments::findOrFail($this->payment_type);
                $payment_type = $payment->type . ' - ' . $payment->name;
            }
            $status = 'PyC';
        }
        $this->merge([
            'business_id' => session()->get('businessId'),
            'branch_id' => session()->get('branchId'),
            'cashbox_id' => session()->get('cashboxId'),
            'user_id' => auth()->user()->id,
            'payment_type' => $payment_type,
            'status' => $status,
            'payment_type_id' => $payment_type_id,
            'processtype_id' => 3,
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'start_date' => 'required|date',
            'room_id' => 'required',
            'days' => 'required|integer',
            'amount' => 'required',
            'number' => 'required|string',
            'date' => 'required|date',
            'client_id' => 'required',
        ];
        if ($this->billingToggle == 'on') {
            $rules['clientBilling'] = 'required|integer';
            $rules['payment_type'] = 'required';
            $rules['document'] = 'required';
            $rules['documentNumber'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'start_date.required' => 'La fecha de inicio es requerida',
            'start_date.date' => 'La fecha de inicio debe ser una fecha válida',
            'room_id.required' => 'La habitación es requerida',
            'days.required' => 'El campo noches es requerido',
            'days.integer' => 'El campo noche tiene formato incorrecto',
            'amount.required' => 'El monto es requerido',
            'number.required' => 'El número es requerido',
            'number.string' => 'El número debe ser una cadena de texto',
            'date.required' => 'La fecha es requerida',
            'date.date' => 'La fecha debe ser una fecha válida',
            'client_id.required' => 'El cliente es requerido',
            'clientBilling.required' => 'El cliente para facturación es requerido',
            'payment_type.required' => 'El tipo de pago es requerido',
            'document.required' => 'El documento de facturación es requerido',
            'documentNumber.required' => 'El número de documento de facturación es requerido',
        ];
    }
}