<?php

namespace App\Http\Requests;

use App\Models\Payments;
use Illuminate\Foundation\Http\FormRequest;

class UpdateManagementRequest extends FormRequest
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

        if ($this->status == 'PyNC') {
            if ($this->payment_type == 5) {
                $payment_type = 'COMBINADO';
            } else {
                $payment = Payments::findOrFail($this->payment_type);
                $payment_type = $payment->type . ' - ' . $payment->name;
            }
        }
        $this->merge([
            'business_id' => session()->get('businessId'),
            'branch_id' => session()->get('branchId'),
            'cashbox_id' => session()->get('cashboxId'),
            'user_id' => auth()->user()->id,
            'payment_type' => $payment_type,
            'payment_type_id' => $payment_type_id,
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
            'end_date' => 'required|date',
        ];
        if ($this->status == 'PyNC') {
            $rules['clientBilling'] = 'required|integer';
            $rules['payment_type'] = 'required';
            $rules['document'] = 'required';
            $rules['documentNumber'] = 'required';
        }
        return $rules;
    }
}