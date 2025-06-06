<?php

namespace App\Http\Requests;

use App\Utils\Utils;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('id'); // Assumes route model binding or parameter

        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'password' => 'sometimes|string|min:6',
            'role' => 'sometimes|in:' . implode(',', Utils::ROLES),
            'phone_number' => 'nullable|string|max:20',
            'status' => 'sometimes|in:' . implode(',', Utils::STATUSES),
        ];
    }
}
