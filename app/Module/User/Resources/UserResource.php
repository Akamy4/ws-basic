<?php

declare(strict_types=1);

namespace App\Module\User\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property User $resource
 */
final class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->resource->id,
            'email' => $this->resource->email,
        ];
    }
}
