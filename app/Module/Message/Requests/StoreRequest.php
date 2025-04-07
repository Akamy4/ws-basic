<?php

declare(strict_types=1);

namespace App\Module\Message\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => ['required', 'string']
        ];
    }
}
