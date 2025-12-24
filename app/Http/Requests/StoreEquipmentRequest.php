<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Authorize the request
     */
    public function authorize(): bool
    {
        return true; // Change if using policies/permissions
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:100',
                // Unique code, ignore current ID on update if needed
                Rule::unique('equipments', 'code')->ignore($this->equipment?->id),
            ],
            'category_id' => 'nullable|exists:equipment_categories,id',
            'district_id' => 'nullable|exists:districts,id',
            'activity_id' => 'nullable|exists:activities,id',
            'resource_type_id' => 'nullable|exists:resource_types,id',
            'quantity' => 'required|integer|min:0',
            'remarks' => 'nullable|string|max:500',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Custom messages (optional)
     */
    public function messages(): array
    {
        return [
            'code.unique' => 'This equipment code is already taken.',
            'quantity.min' => 'Quantity cannot be negative.',
            'category_id.exists' => 'Selected category does not exist.',
            'district_id.exists' => 'Selected district does not exist.',
            'activity_id.exists' => 'Selected activity does not exist.',
            'resource_type_id.exists' => 'Selected resource type does not exist.',
        ];
    }

    /**
     * Sanitize/prepare input before validation (optional)
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->has('is_active') ? (bool)$this->is_active : true,
        ]);
    }
}
