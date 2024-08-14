<div x-init="setTimeout(() => {

    conversationElement = document.getElementById('conversation-' + query);
    chatList = document.getElementById('chat-list');


    //scroll to the element

    if (conversationElement) {

        conversationElement.scrollIntoView({ 'behavior': 'smooth' });

    }

}, 200);"
    @update-conversation.window="
 $nextTick(() => {
            chatList.scrollTo({
                top: 0,
                behavior: 'smooth'  
            });
        });
 "
    class="flex flex-col transition-all h-full overflow-hidden w-full">

    <header class="px-3 z-10 sticky top-0 w-full py-2 dark:bg-gray-900 dark:text-white">

        <div class="border-b justify-between flex items-center pb-2">

            <div class="flex items-center gap-2">
                <h5 class="font-extrabold text-2xl ml-4">Chats</h5>
            </div>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button>

                        <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="#9CA3AF" viewBox="0 0 16 16">
                            <path
                                d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z" />
                        </svg>

                    </button>
                </x-slot>

                <x-slot name="content">

                    <div class="w-full p-1" x-data="{ sortOrder: @entangle('sortOrder') }">

                        <a @click.prevent="$wire.setSortOrder('desc')" @class([
                            'cursor-pointer items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100',
                            'bg-gray-100' => $sortOrder == 'desc',
                        ])>

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                </svg>
                            </span>

                            Newest to oldest

                        </a>

                        <a @click.prevent="$wire.setSortOrder('asc')" @class([
                            'cursor-pointer items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100',
                            'bg-gray-100' => $sortOrder == 'asc',
                        ])>

                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z" />
                                </svg>
                            </span>

                            oldest to Newest

                        </a>


                    </div>

                </x-slot>
            </x-dropdown>

        </div>

        {{-- MS Filters Actions --}}

        <div class="flex gap-3 items-center p-2 bg-white  dark:bg-gray-900 dark:text-white">

            <button @click.prevent="$wire.SetgetAllConversations" @class([
                'inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border',
                'bg-blue-100 border-0 text-black' =>
                    !$getConversationsHasUnreadMessages && !$getFavouriteConversations,
            ])>
                All
            </button>

            <button @click.prevent="$wire.SetUnreadConversations" @class([
                'inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border',
                'bg-blue-100 border-0 text-black' =>
                    $getConversationsHasUnreadMessages && !$getFavouriteConversations,
            ])>
                Unread
            </button>

            <button @click.prevent="$wire.SetFavouriteConversations" @class([
                'inline-flex justify-center items-center rounded-full gap-x-1 text-xs font-medium px-3 lg:px-5 py-1  lg:py-2.5 border',
                'bg-blue-100 border-0 text-black' =>
                    !$getConversationsHasUnreadMessages && $getFavouriteConversations,
            ])>
                Favourites
            </button>


        </div>


    </header>

    <main id="chat-list"
        class="overflow-y-scroll overflow-hidden grow w-fixed h-full relative  dark:bg-gray-900 dark:text-white"
        style="contain:content">

        {{-- MS - chatlist  --}}

        <ul class="p-2 grid w-full spacey-y-2">


            @if (count($conversations) > 0)

                @foreach ($conversations as $conversation)
                    <li id="conversation-{{ $conversation->id }}" wire:key="{{ $conversation->id }}"
                        class="py-3 hover:bg-gray-50 my-1 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->id ? 'bg-gray-100/70' : '' }}">

                        <a class="shrink-0">
                            @if ($conversation->getReceiver()->avatar)
                                <x-avatar src="{{ url('storage/' . $conversation->getReceiver()->avatar) }}" />
                            @else
                                <x-avatar />
                            @endif
                        </a>

                        <aside class="grid grid-cols-12 w-full">


                            <a wire:navigate href={{ route('chat', $conversation->id) }}
                                class="col-span-11 border-b pb-2 border-gray-200 relative overflow-hidden truncate leading-5 w-full flex-nowrap p-1">

                                {{-- MS - name and date  --}}

                                <div class="flex justify-between w-full items-center">

                                    <h6 class="truncate font-medium tracking-wider text-gray-900  dark:text-gray-300">
                                        {{ $conversation->getReceiver()->name }}
                                    </h6>

                                    <small
                                        class="text-gray-700 dark:text-gray-500">{{ $conversation->messages?->last()?->timeForHumans() }}</small>

                                </div>

                                {{-- MS - Message body --}}

                                <div class="flex gap-x-2 items-center"> 
                                <livewire:message-status-chatlist :conversation="$conversation"/>

                                    <p class="grow truncate text-sm font-[100]">
                                        {{ $conversation->messages?->last()?->body }}
                                    </p>



                                    @if ($conversation->countUnread() > 0)
                                        <span
                                            class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-indigo-500 text-white">
                                            {{ $conversation->countUnread() }}
                                        </span>
                                    @endif



                                </div>

                            </a>

                            {{-- MS - Dropdown --}}

                            <div class="col-span-1 flex flex-col text-center my-auto">

                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor"
                                                class="bi bi-three-dots-vertical ml-2 w-5 h-5 text-gray-700"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />
                                            </svg>


                                        </button>
                                    </x-slot>

                                    <x-slot name="content">

                                        <div class="w-full p-1">

                                            <a wire:navigate
                                                href={{ route('users.show', $conversation->getReceiver()?->id) }}
                                                class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">

                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-person-circle"
                                                        viewBox="0 0 16 16">
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                        <path fill-rule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                                    </svg>
                                                </span>

                                                View Profile

                                            </a>
                                            @if ($conversation->isInAuthUserFavs())
                                                <a wire:click="removeFromFavs({{ $conversation->id }})"
                                                    class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">

                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-heartbreak-fill" viewBox="0 0 16 16">
                                                            <path
                                                                d="M8.931.586 7 3l1.5 4-2 3L8 15C22.534 5.396 13.757-2.21 8.931.586M7.358.77 5.5 3 7 7l-1.5 3 1.815 4.537C-6.533 4.96 2.685-2.467 7.358.77" />
                                                        </svg>
                                                    </span>

                                                    Remove from favourites

                                                </a>
                                            @else
                                                <a wire:click="addToFavs({{ $conversation->id }})"
                                                    class="items-center gap-3 flex w-full px-4 py-2 text-left text-sm leading-5 text-gray-500 hover:bg-gray-100 transition-all duration-150 ease-in-out focus:outline-none focus:bg-gray-100">

                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-heart-fill"
                                                            viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                                        </svg>
                                                    </span>

                                                    Add to favourites

                                                </a>
                                            @endif






                                        </div>

                                    </x-slot>
                                </x-dropdown>



                            </div>


                        </aside>

                    </li>
                @endforeach
            @else
                <div class="text-2xl font-mono text-center text-gray-300">Nothing to see here</div>
            @endif

        </ul>

    </main>



</div>
