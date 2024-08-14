<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class UserShow extends Component
{
    public $user;

    public function redirectToConversation($receiverId){
        $conversationId = Conversation::where("sender_id",auth()->id())->where("receiver_id",$receiverId)->first()->id;
        return to_route("chat",$conversationId);
    }

    public function mount($id){
        $this->user = User::findorfail($id);
    }

    public function render()
    {
        return view('livewire.user-show')->layout("layouts.app");
    }
}
