<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;
    public $sortOrder = 'desc';

    public function setSortOrder($order)
    {
        $this->sortOrder = $order;
    }


    #[On("update-conversation")]
    public function render()
    {
        $conversations = auth()->user()->conversations()->orderBy('updated_at', $this->sortOrder)->get();
        return view('livewire.chat.chat-list', compact('conversations'));
    }
}
