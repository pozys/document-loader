<?php

namespace App\Infrastructure\Http\Requests;

use App\Domain\Enums\DocumentFormats;
use App\Domain\Enums\DocumentTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'document_type' => ['required', 'string', Rule::enum(DocumentTypes::class)],
            'document_format' => ['required', 'string', Rule::enum(DocumentFormats::class)],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'settings' => ['required', 'array'],
        ];
    }
}
