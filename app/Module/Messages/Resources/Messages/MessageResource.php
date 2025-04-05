<?php

declare(strict_types=1);

namespace App\Module\Messages\Resources\Messages;

use App\Module\Messages\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Message $resource
 */
final class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->resource->id,
            'body' => $this->resource->body,
            'time' => $this->resource->created_at->diffForHumans(),
        ];
    }
}
