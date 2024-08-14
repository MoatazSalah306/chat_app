<?php

namespace App\Livewire;

use Livewire\Component;

class MessageStatusChatlist extends Component
{
    public $conversation;
    
    
    public function render()
    {
        return view('livewire.message-status-chatlist');
    }
}
