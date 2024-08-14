<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable=[
        'body',
        'sender_id',
        'receiver_id',
        'conversation_id',
        'read_at',
        'receiver_deleted_at',
        'sender_deleted_at',
    ];

    protected $dates = ['read_at','receiver_deleted_at','sender_deleted_at'];

    public function conversation():BelongsTo{
        return $this->belongsTo(Conversation::class);
    }

    public function isRead():bool{
        return $this->read_at != null;
    }

    public function timeForHumans()
    {
        $created = $this->created_at;
        $now = Carbon::now();

        if ($created->diffInSeconds($now) < 60) {
            return 'Just now';
        }

        return $created->shortAbsoluteDiffForHumans();
    }
}
