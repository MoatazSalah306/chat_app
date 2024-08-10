<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable=[
        'receiver_id',
        'sender_id'
    ];

    public function messages():HasMany{
        return $this->hasMany(Message::class);
    }

    public function getReceiver()
    {

        if ($this->sender_id === auth()->id()) {

            return User::firstWhere('id',$this->receiver_id);

        } else {

            return User::firstWhere('id',$this->sender_id);
        }
        

    }



 


    public function countUnread()
    {

        return $unreadMessages= $this->messages()->whereNull("read_at")->where("receiver_id",auth()->user()->id)->count();
        

    }
    
    
}
