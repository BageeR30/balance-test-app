<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TableRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'search' => ['nullable', 'string'],
            'sort' => ['sometimes', 'string'],
            'order' => ['sometimes', Rule::in(['ascending', 'descending'])],
        ];
    }

    public function passedValidation(): void
    {
        if (!$this->order) {
            return;
        }

        $order = match ($this->order) {
            'ascending' => 'asc',
            'descending' => 'desc',
        };

        $this->merge(['order' => $order]);
    }
}
