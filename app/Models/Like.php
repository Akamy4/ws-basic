<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property-read Carbon|null created_at
 * @property-read User $fromUser
 * @property-read User $toUser
 */
class Like extends Model
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

    public function likeCount(): int
    {
        return $this->toUser()->count();
    }
}
