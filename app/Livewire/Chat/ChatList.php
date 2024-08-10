<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;




    #[On("update-conversation")]
    public function render()
    {

        $conversations = auth()->user()->conversations()->latest('updated_at')->get();
        return view('livewire.chat.chat-list', compact('conversations'));
    }
}
