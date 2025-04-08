<?php

declare(strict_types=1);

namespace App\Module\Chat\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Module\Chat\Events\ChatStoredEvent;
use App\Module\Chat\Models\Chat;
use App\Module\Chat\Requests\StoreChatRequest;
use App\Module\Chat\Resources\Messages\ChatResource;
use Illuminate\Support\Facades\Auth;

final class ChatsController extends Controller
{
    public function chat(int $userId)
    {
        $chats = Chat::query()
            ->where(function ($query) use ($userId) {
                $query->where('from_user_id', Auth::id())
                    ->where('to_user_id', $userId);
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('from_user_id', $userId)
                    ->where('to_user_id', Auth::id());
            })
            ->latest()
            ->get();

        $chats = ChatResource::collection($chats)->resolve();

        $user = User::query()->findOrFail($userId);

        return inertia('Chat/Show', compact('chats', 'user'));
    }


    public function store(StoreChatRequest $request)
    {
        $data = $request->validated();
        /** @var Chat $chat */
        $chat = Chat::query()
            ->create([
                'message'      => $data['message'],
                'to_user_id'   => $data['toUserId'],
                'from_user_id' => Auth::id()
            ]);

        broadcast(new ChatStoredEvent($chat))->toOthers();

        return (new ChatResource($chat))->resolve();
    }
}
