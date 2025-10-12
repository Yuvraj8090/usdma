<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeploymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'resource_type' => 'sometimes|required|string|in:App\Models\Equipment,App\Models\Manpower,App\Models\ReliefMaterial',
            'resource_id'   => 'sometimes|required|integer',
            'location'      => 'sometimes|required|string|max:255',
            'status'        => 'sometimes|required|string|in:active,completed,pending',
            'deployed_at'   => 'nullable|date',
            'returned_at'   => 'nullable|date|after_or_equal:deployed_at',
        ];
    }
}
