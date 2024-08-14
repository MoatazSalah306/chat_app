<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class MessageStatusChatbox extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.message-status-chatbox');
    }
}
