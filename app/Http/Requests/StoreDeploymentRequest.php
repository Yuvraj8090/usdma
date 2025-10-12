<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeploymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resource_type' => 'required|string|in:App\Models\Equipment,App\Models\Manpower,App\Models\ReliefMaterial',
            'resource_id'   => 'required|integer',
            'location'      => 'required|string|max:255',
            'status'        => 'required|string|in:active,completed,pending',
            'deployed_at'   => 'nullable|date',
            'returned_at'   => 'nullable|date|after_or_equal:deployed_at',
        ];
    }
}
