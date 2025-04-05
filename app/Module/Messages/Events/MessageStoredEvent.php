<?php

declare(strict_types=1);

namespace App\Module\Messages\Events;

use App\Module\Messages\Models\Message;
use App\Module\Messages\Resources\Messages\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class MessageStoredEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private readonly Message $message,
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('message-stored'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'message-stored';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => (new MessageResource($this->message))->resolve(),
        ];
    }
}
