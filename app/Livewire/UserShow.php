<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserShow extends Component
{
    public $user;

    public function mount($id){
        $this->user = User::findorfail($id);
    }

    public function render()
    {
        return view('livewire.user-show')->layout("layouts.app");
    }
}
