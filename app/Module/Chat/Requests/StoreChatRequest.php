<?php

declare(strict_types=1);

namespace App\Module\Chat\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreChatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message'  => ['required', 'string'],
            'toUserId' => ['required', 'int'],
        ];
    }
}
