<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;


class ChatBox extends Component
{
    public $selectedConversation;
    public $loadedMessages;
    public $paginate_var = 10;



    public function getListeners()
    {

        $auth_id = auth()->user()->id;

        return [
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications',
        ];
    }



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
        $this->dispatch('update-chat-height');
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
         
                $this->selectedConversation->countUnread();

                $this->selectedConversation->getReceiver()->notify( new MessageRead(
                    $this->selectedConversation->id
                ));
            }
        }
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


        $this->reset('body');


        #scroll to bottom
        $this->dispatch('scroll-bottom');


        #update conversation model
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();

        $this->dispatch("update-conversation");

        $this->reset('body');

        // MS - Send the notification
        Notification::send($this->selectedConversation->getReceiver(), new MessageSent(
            Auth::user(),
            $createdMessage,
            $this->selectedConversation,
            $this->selectedConversation->getReceiver()->id
        ));

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
