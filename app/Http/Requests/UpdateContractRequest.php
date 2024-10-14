<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'station_name' => 'required|string',
            'station_nit' => 'required|string',
            'city' => 'required|string',
            'contract_number' => 'required|string',
            'fuel_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'quantity' => 'required|integer',
            'balance' => 'required|integer',
            'unit_price' => 'required|decimal:1,2',
            'total_amount' => 'required|decimal:1,2'

        ];
    }
}
