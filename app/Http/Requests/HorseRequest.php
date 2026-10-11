<?php

namespace App\Http\Requests;

use App\Models\Horse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HorseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'breed_id' => ['required', 'exists:breeds,id'],
            'gender' => ['required', Rule::in(Horse::GENDERS)],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
            'discipline' => ['required', Rule::in(Horse::DISCIPLINES)],
            'city' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['boolean'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ];
    }

    /**
     * Get the field names to use in error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'breed_id' => 'breed',
        ];
    }
}
