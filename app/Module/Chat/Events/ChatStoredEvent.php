<?php

declare(strict_types=1);

namespace App\Module\Chat\Events;

use App\Module\Chat\Models\Chat;
use App\Module\Chat\Resources\Messages\ChatResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class ChatStoredEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Chat $chat,
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->chat->from_user_id . '.' . $this->chat->to_user_id),
        ];
    }


    public function broadcastAs(): string
    {
        return 'chat-stored';
    }

    public function broadcastWith(): array
    {
        return [
            'chat' => (new ChatResource($this->chat))->resolve(),
        ];
    }
}
