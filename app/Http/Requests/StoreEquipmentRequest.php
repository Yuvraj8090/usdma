<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // add auth logic if needed
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'type'     => 'nullable|string|max:255',
            'status'   => 'nullable|string|in:available,in-use,maintenance',
            'quantity' => 'required|integer|min:1',
        ];
    }
}
