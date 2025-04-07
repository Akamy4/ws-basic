<?php

declare(strict_types=1);

namespace App\Module\User\Events;

use App\Models\Like;
use App\Module\User\Resources\LikeResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class LikeStoredEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Like $like,
    ) {
    }

    public function broadcastOn(): array
    {
        return array(
            new Channel('like-stored-' . $this->like->to_user_id),
        );
    }

    public function broadcastAs(): string
    {
        return 'like-stored';
    }

    public function broadcastWith(): array
    {
        return [
            'like' => (new LikeResource($this->like))->resolve(),
        ];
    }
}
