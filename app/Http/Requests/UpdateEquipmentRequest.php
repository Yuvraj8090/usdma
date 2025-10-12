<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'sometimes|required|string|max:255',
            'type'     => 'nullable|string|max:255',
            'status'   => 'nullable|string|in:available,in-use,maintenance',
            'quantity' => 'sometimes|required|integer|min:1',
        ];
    }
}
