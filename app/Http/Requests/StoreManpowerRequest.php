<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManpowerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // You can add authorization logic if needed
    }

    public function rules(): array
    {
        return [
            'category'    => 'required|string|max:255',
            'district_id' => 'required|exists:districts,id',
            'count'       => 'required|integer|min:1',
            'remarks'     => 'nullable|string|max:1000',
        ];
    }
}
