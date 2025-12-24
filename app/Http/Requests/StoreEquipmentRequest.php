<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:equipments,code',
            'category_id' => 'nullable|exists:equipment_categories,id',
            'district_id' => 'nullable|exists:districts,id',
            'quantity' => 'required|integer|min:0',
            'remarks' => 'nullable|string',
            'is_active' => 'boolean'
        ];
    }
}