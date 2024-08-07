<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;
    
    public function render()
    {
        $conversations = auth()->user()->conversations()->latest('updated_at')->get();
        return view('livewire.chat.chat-list',compact('conversations'));
    }
}
