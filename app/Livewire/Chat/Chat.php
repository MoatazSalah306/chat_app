<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{
    public $query;
    public $selectedConversation;
    

    public function mount(){
        $this->selectedConversation = Conversation::findOrFail($this->query);

          #mark message belogning to receiver as read 
        Message::where('conversation_id',$this->selectedConversation->id)
        ->where('receiver_id',auth()->id())
        ->whereNull('read_at')
        ->update(['read_at'=>now()]);
    }

    public function render()
    {
        return view('livewire.chat.chat')->layout("layouts.app");
    }
}
