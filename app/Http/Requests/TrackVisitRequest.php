<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackVisitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => ['required', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'page.required' => 'The page URL is required.',
            'page.url' => 'The page must be a valid URL.',
        ];
    }
}
