<?php

declare(strict_types=1);

namespace App\Module\Chat\Resources\Messages;

use App\Module\Chat\Models\Chat;
use App\Module\User\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @property Chat $resource
 */
final class ChatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->resource->id,
            'message'   => $this->resource->message,
            'toUser'    => new UserResource($this->resource->toUser),
            'initiator' => $this->resource->getInitiator(),
            'time'      => $this->resource->created_at->toDateTimeString(),
        ];
    }
}
