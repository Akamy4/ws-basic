<?php

declare(strict_types=1);

namespace App\Module\Messages\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Module\Messages\Events\MessageStoredEvent;
use App\Module\Messages\Models\Message;
use App\Module\Messages\Requests\StoreRequest;
use App\Module\Messages\Resources\Messages\MessageResource;
use Inertia\Response;

final class MessageController extends Controller
{
    public function index(): Response
    {
        $messages = Message::query()->latest()->get();
        $messages = MessageResource::collection($messages)->resolve();
        return inertia('Message/Index', compact('messages'));
    }

    public function store(StoreRequest $request): array
    {
        $data = $request->validated();
        /** @var Message $message */
        $message = Message::query()->create($data);

        broadcast(new MessageStoredEvent($message))->toOthers();

        return (new MessageResource($message))->resolve();
    }
}
