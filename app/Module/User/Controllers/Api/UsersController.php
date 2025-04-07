<?php

declare(strict_types=1);

namespace App\Module\User\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\User;
use App\Module\Message\Events\MessageStoredEvent;
use App\Module\User\Events\LikeStoredEvent;
use App\Module\User\Resources\LikeResource;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

final class UsersController extends Controller
{
    public function show(int $id): Response
    {
        $user = User::query()->findOrFail($id);
        return inertia('User/Show', compact('user'));
    }

    public function like(int $id)
    {
        if ((int)Auth::id() === $id) {
            return;
        }

        /** @var Like $like */
        $like = Like::query()->create([
            'from_user_id' => (int)Auth::id(),
            'to_user_id'   => $id,
        ]);

        broadcast(new LikeStoredEvent($like))->toOthers();

        return response()->json(new LikeResource($like));
    }
}
