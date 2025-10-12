<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReliefMaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'sometimes|required|string|max:255',
            'category' => 'nullable|string|max:255',
            'quantity' => 'sometimes|required|integer|min:0',
            'unit'     => 'sometimes|required|string|max:20',
            'status'   => 'nullable|string|in:available,deployed,low-stock',
        ];
    }
}
