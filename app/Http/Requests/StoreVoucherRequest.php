<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            'date' => 'required|date',
            'delivery_to' => 'required|string',
            'vehicle' => 'required|string',
            'plate' => 'required|string',
            'kilometer' => 'required|string',
            'station_name' => 'required|string',
            'total_amount' => 'required|decimal:2',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer',
            'items.*.description' => 'required|string',
            'items.*.unit_price' => 'required|decimal:2',
            'items.*.total_price' => 'required|decimal:2'
        ];
    }
}
