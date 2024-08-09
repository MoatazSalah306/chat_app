<div x-data="{
    height: 0,
    conversationElement: document.getElementById('conversation')
}" x-init="height = conversationElement.scrollHeight;
$nextTick(() => {
    conversationElement.scrollTo({
        top: height,
        behavior: 'smooth'
    });
});"

    @scroll-bottom.window="
 $nextTick(() => {
            conversationElement.scrollTo({
                top: height,
                behavior: 'smooth'  
            });
        });
 "
    class="w-full overflow-hidden">

    <div class="border-b flex flex-col grow h-full">


        {{-- MS - Header --}}

        <header class="w-full sticky inset-x-0 flex pb-[5px] pt-[5px] top-0 z-10 bg-white border-b ">

            <div class="flex w-full items-center px-2 lg:px-4 gap-2 md:gap-5">

                <a class="shrink-0 lg:hidden" href="#">


                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                    </svg>


                </a>


                {{-- avatar --}}


                <div class="shrink-0">
                    <x-avatar class="h-9 w-9 lg:w-11 lg:h-11" />
                </div>


                <h6 class="font-bold truncate"> {{ $selectedConversation->getReceiver()->name }}</h6>


            </div>


        </header>

        {{-- MS - Body --}}
        <main
            @scroll="
        scrollTop = $el.scrollTop;
        if (scrollTop <= 0) {
            $wire.dispatch('LoadMoreMessages')
        }
    "

            id="conversation"
            class="flex flex-col gap-3 p-2.5 overflow-y-auto  flex-grow overscroll-contain overflow-x-hidden w-full my-auto">



            @if ($loadedMessages)
                @php
                    $previousMessage = null;
                @endphp
                @foreach ($loadedMessages as $key => $message)
                    @if ($key > 0)
                        @php
                            $previousMessage = $loadedMessages->get($key - 1);
                        @endphp
                    @endif
                    <div @class([
                        'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2',
                        'ml-auto' => $message->sender_id === auth()->id(),
                    ])>

                        {{-- avatar --}}

                        <div @class([
                            'shrink-0',
                            'invisible' => $previousMessage?->sender_id == $message->sender_id,
                            'hidden' => $message->sender_id === auth()->id(),
                        ])>
                            <x-avatar />
                        </div>
                        {{-- messsage body --}}

                        <div @class([
                            'flex flex-wrap text-[15px] rounded-xl p-2.5 flex flex-col text-black',
                            'rounded-bl-none border border-gray-200/40 bg-[#f6f6f8fb]' => !(
                                $message->sender_id == auth()->id()
                            ),
                            'rounded-br-none text-white bg-indigo-400' =>
                                $message->sender_id == auth()->id(),
                        ])>



                            <p class="whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal">
                                {{ $message->body }}
                            </p>


                            <div class="ml-auto flex gap-2">

                                <p @class([
                                    'text-xs ',
                                    'text-gray-500' => !$message->sender_id == auth()->id(),
                                    'text-white' => $message->sender_id == auth()->id(),
                                ])>


                                    {{ $message->created_at->format('g:i a') }}

                                </p>


                                {{-- message status , only show if message belongs auth --}}


                                <div>

                                    @if ($message->sender_id == auth()->id())
                                        @if ($message->isRead())
                                            {{-- MS - double check --}}

                                            <span @class('text-gray-200')>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                                    <path
                                                        d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                                                    <path
                                                        d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                                                </svg>
                                            </span>
                                        @else
                                            {{-- MS - single check --}}
                                            <span @class('text-gray-200')>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                                </svg>
                                            </span>
                                        @endif
                                    @endif





                                </div>



                            </div>

                        </div>







                    </div>
                @endforeach
            @endif



        </main>

        {{-- MS - send message & Footer  --}}

        <footer class="shrink-0 z-10 bg-white inset-x-0">

            <div class=" p-2 border-t">

                <form wire:submit="sendMessage" autocapitalize="off">
                    @csrf

                    <input type="hidden" autocomplete="false" style="display:none">

                    <div class="grid grid-cols-12">
                        <input wire:model="body" type="text" autocomplete="off" autofocus
                            placeholder="write your message here" maxlength="1700"
                            class="col-span-10 bg-gray-100 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounded-lg  focus:outline-none">

                        <x-primary-button type="submit" class="ml-1 col-span-2 flex items-center justify-center">
                            send
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
                                class="bi bi-send ml-1" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                            </svg>
                        </x-primary-button>
                    </div>

                </form>

                {{-- @error('body')

            <p> {{$message}} </p>
                
            @enderror --}}

            </div>





        </footer>


    </div>

</div>
