<?php

namespace App\Module\Chat\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * @property int $id
 * @property string $message
 * @property int $from_user_id
 * @property int $to_user_id
 * @property Carbon|null $created_at
 * @property User $fromUser
 * @property User $toUser
 */
final class Chat extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getInitiator(): string
    {
        return $this->fromUser->name;
    }

}
