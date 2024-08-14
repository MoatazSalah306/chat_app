<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Favourite;
use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;
    public $sortOrder = 'desc';
    protected $queryString = ['getAllConversations','getFavouriteConversations', 'getConversationsHasUnreadMessages','sortOrder'];
    public $getAllConversations;
    public $getConversationsHasUnreadMessages;
    public $getFavouriteConversations;


    public function removeFromFavs($conversationId){
        Favourite::where("user_id",auth()->id())->where("conversation_id",$conversationId)->delete();
    }

    public function addToFavs($conversationId)
    {
        Favourite::create([
            "user_id" => auth()->id(),
            "conversation_id" => $conversationId
        ]);
        $this->SetFavouriteConversations();
    }

    public function SetgetAllConversations()
    {
        $this->getAllConversations = true;
        session(['getAllConversations' => $this->getAllConversations]);

        $this->getConversationsHasUnreadMessages = false;
        session(['getConversationsHasUnreadMessages' => $this->getConversationsHasUnreadMessages]);

        $this->getFavouriteConversations = false;
        session(['getFavouriteConversations' => $this->getFavouriteConversations]);

    }

    public function SetFavouriteConversations()
    {
        $this->getFavouriteConversations = true;
        session(['getFavouriteConversations' => $this->getFavouriteConversations]);

        $this->getConversationsHasUnreadMessages = false;
        session(['getConversationsHasUnreadMessages' => $this->getConversationsHasUnreadMessages]);

        $this->getAllConversations = false;
        session(['getAllConversations' => $this->getAllConversations]);
    }

    public function SetUnreadConversations()
    {
        $this->getConversationsHasUnreadMessages = true;
        session(['getConversationsHasUnreadMessages' => $this->getConversationsHasUnreadMessages]);

        $this->getFavouriteConversations = false;
        session(['getFavouriteConversations' => $this->getFavouriteConversations]);

        $this->getAllConversations = false;
        session(['getAllConversations' => $this->getAllConversations]);
    }




    public function setSortOrder($order)
    {
        $this->sortOrder = $order;
        session(['sortOrder' => $this->sortOrder]);

    }



    public function getListeners()
    {

        $auth_id = auth()->user()->id;

        return [
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications',
        ];
    }





    public function mount()
    {
        $this->getFavouriteConversations = session('getFavouriteConversations', false);
        $this->getConversationsHasUnreadMessages = session('getConversationsHasUnreadMessages', false);
    }

    #[On(["conversation-created", "update-conversation"])]
    public function render()
    {
        $userId = auth()->id();

        if ($this->getConversationsHasUnreadMessages) {
            $conversations = Conversation::where(function ($query) use ($userId) {
                $query->where('receiver_id', $userId);
                $query->orWhere('sender_id', $userId);
            })->whereHas('messages', function ($query) use ($userId) {
                $query->whereNull('read_at');
                $query->where('receiver_id', $userId);
            })->orderBy('updated_at', $this->sortOrder)->get();
        } elseif ($this->getFavouriteConversations) {
            $conversations = auth()->user()->favouriteConversations()->get();
        }else{
            $conversations = Conversation::where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            })->orderBy('updated_at', $this->sortOrder)->get();
        }

        return view('livewire.chat.chat-list', compact('conversations'));
    }
}
