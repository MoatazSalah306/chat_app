<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function message($userId)
    {
       $authUserId = auth()->user()->id;

       # MS - Check if there's an existing conversation between them.

       $existingConversation = Conversation::where(function($query) use($userId,$authUserId){
            $query->where("sender_id",$authUserId)
                  ->where("reciever_id",$userId);
       })
       ->orWhere(function ($query) use ($userId,$authUserId){
            $query->where("reciever_id",$authUserId)
                  ->where("sender_id",$userId); 
       })->first();

       if ($existingConversation) {
            return to_route("chat",$existingConversation->id);
       }

       # MS - elsewhere we will create a new conversation
       $createdConversation = Conversation::create([
        "sender_id" => $authUserId,
        "reciever_id" => $userId
       ]);

       return to_route("chat",$createdConversation->id);
    
    }

    public function render()
    {
        return view('livewire.users', ['users' => User::where("id", '!=', auth()->user()->id)->get()])->layout("layouts.app");
    }
}
