<?php

namespace App\Module\Messages\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $body
 * @property Carbon|null $created_at
 */
final class Message extends Model
{
    use HasFactory;

    protected $guarded = false;
}
