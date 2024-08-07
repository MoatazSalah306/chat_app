<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $loadedMessages;


    #[Rule("required|max:1400")]
    public $body;

    public function sendMessage(){
        $this->validate();
        $createdMessage = Message::create([
            
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body

        ]);

        $this->reset('body');

    }

    public function LoadMessages(){
        $this->loadedMessages = $this->selectedConversation->messages()->get();
    }
    
    public function mount(){
        $this->LoadMessages();
    }

    public function render()
    {
        $this->LoadMessages();
        return view('livewire.chat.chat-box');
    }
}
