<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "avatar"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'sender_id')->orWhere('receiver_id', $this->id);
    }

    /**
     * The channels the user receives notification broadcasts on.
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'users.' . $this->id;
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function favouriteConversations()
    {
        return $this->hasManyThrough(Conversation::class, Favourite::class, 'user_id', 'id', 'id', 'conversation_id');
    }

    public function countConversations()
    {
        return Conversation::where('sender_id', $this->id)
            ->orWhere('receiver_id', $this->id)
            ->count();
    }
}
