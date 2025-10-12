<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManpowerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add authorization if required
    }

    public function rules(): array
    {
        return [
            'category'    => 'sometimes|required|string|max:255',
            'district_id' => 'sometimes|required|exists:districts,id',
            'count'       => 'sometimes|required|integer|min:1',
            'remarks'     => 'nullable|string|max:1000',
        ];
    }
}
