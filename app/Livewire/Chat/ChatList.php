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



    public function getListeners()
    {

        $auth_id = auth()->user()->id;

        return [
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications',
        ];
    }

    
    public function broadcastedNotifications($event){
        if( $event['type'] === MessageSent::class){
            if ($event["conversation_id"] === $this->selectedConversation->id) {
                $this->dispatch('scroll-bottom');

                $newMessage = Message::find($event['message_id']);


                # MS - push message
                $this->loadedMessages->push($newMessage);
                $newMessage->read_at = now();
                $newMessage->save();

                $this->selectedConversation->getReceiver()->notify( new MessageRead(
                    $this->selectedConversation->id
                ));
            }
        }
    }


    #[On(["conversation-created","update-conversation"])]
    public function render()
    {
        $conversations = auth()->user()->conversations()->orderBy('updated_at', $this->sortOrder)->get();
        return view('livewire.chat.chat-list', compact('conversations'));
    }
}
