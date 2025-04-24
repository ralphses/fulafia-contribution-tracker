<?php

namespace App\Http\Requests;

use App\Utils\Utils;
use Illuminate\Foundation\Http\FormRequest;

class FilterUsersRequest extends FormRequest
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
            'role' => 'nullable|in:' . implode(',', Utils::ROLES),
            'status' => 'nullable|in:' . implode(',', Utils::STATUSES),
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
