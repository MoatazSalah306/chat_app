<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $loadedMessages;
    public $paginate_var = 10;



    #[Rule("required|max:1400")]
    public $body;


    #[On('LoadMoreMessages')]
    public function loadMore(): void
    {

        # MS - increment 
        $this->paginate_var += 10;

        # MS - call loadMessages function

        $this->loadMessages();

        # MS - Update the chat height 
        // $this->dispatch('update-chat-height');
    }

    public function LoadMessages()
    {
        $count = $this->selectedConversation->messages()->count();
        return $this->loadedMessages = $this->selectedConversation->messages()
            ->skip($count - $this->paginate_var)
            ->take($this->paginate_var)
            ->get();
    }

    public function sendMessage()
    {
        $this->validate();
        $createdMessage = Message::create([

            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body

        ]);
        $this->dispatch("scroll-bottom");

        #update conversation model
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();
        $this->dispatch("update-conversation");

        $this->reset('body');
    }

    public function mount()
    {
        $this->LoadMessages();
    }

    public function render()
    {
        $this->LoadMessages();
        return view('livewire.chat.chat-box');
    }
}
