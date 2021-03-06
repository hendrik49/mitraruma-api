<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpUserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'chat_room_id',
        'text',
        'is_read'
    ];
}
