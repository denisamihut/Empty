<?php

namespace App\Http\Requests;

use App\Models\Payments;
use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
        if ($this->payment_type == 5) {
            $payment_type = 'COMBINADO';
        } else {
            $payment = Payments::findOrFail($this->payment_type);
            $payment_type = $payment->type . ' - ' . $payment->name;
        }
        $this->merge([
            'business_id' => session()->get('businessId'),
            'branch_id' => session()->get('branchId'),
            'cashbox_id' => session()->get('cashboxId'),
            'user_id' => auth()->user()->id,
            'payment_type' => $payment_type,
            'status' => 'C',
            'payment_type_id' => $payment_type_id,
            'processtype_id' => 1,
            'client_id' => $this->clientBilling ?? 1,
            'total' => $this->totalCart,
            'amount' => $this->totalCart,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'totalCart' => 'required|numeric',
            'payment_type' => 'required',
            'document' => 'required',
            'documentNumber' => 'required',
            'clientBilling' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'totalCart.required' => 'El total de la venta es requerido',
            'totalCart.numeric' => 'El total de la venta debe ser un número',
            'payment_type.required' => 'El campo forma de pago es requerido',
            'document.required' => 'El campo tipo de documento es requerido',
            'documentNumber.required' => 'El campo número de documento es requerido',
            'clientBilling.required' => 'El cliente es requerido',
        ];
    }
}