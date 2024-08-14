<?php

namespace App\Livewire\Chat;

use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    
    #[On("conversation-created")]
    public function render()
    {
        return view('livewire.chat.index')->layout("layouts.app");
    }
}
