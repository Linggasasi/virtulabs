<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExperimentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'laboratory_id' => ['required', 'integer', 'exists:laboratories,id'],
            'material_id' => [
                'nullable',
                'integer',
                Rule::exists('materials', 'id')
                    ->where('laboratory_id', $this->input('laboratory_id')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'objectives' => ['nullable', 'string'],
            'instructions' => ['nullable', 'string'],
            'simulation_type' => ['nullable', 'string', 'max:255'],
        ];
    }
}
