<?php

declare(strict_types=1);

namespace App\Module\User\Resources;

use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Like $resource
 */
final class LikeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'fromUser' => new UserResource($this->resource->fromUser),
            'toUser'   => new UserResource($this->resource->toUser),
            'count'    => $this->resource->toUser->likesCount(),
            'time'     => $this->resource->created_at->diffForHumans(),
        ];
    }
}
