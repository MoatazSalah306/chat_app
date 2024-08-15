<div class="max-w-6xl mx-auto my-16">

    <h5 class="text-5xl font-mono text-gray-300 text-center mb-6">
    
        Chatter Users
       
    </h5>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 p-2 ">

        @foreach ($users as $key=> $user)
            
            {{-- child --}}
            <div class="w-full bg-white border border-gray-200 rounded-tl-2xl rounded-tr-2xl rounded-bl-2xl p-5 shadow">

                <div class="flex flex-col items-center pb-8">

                    @if ($user->avatar)
                    <x-avatar src="{{ url('storage/' . $user->avatar) }}" class="w-24 h-24 mb-2 5 rounded-full shadow-lg"/>
                    @else
                        <x-avatar class="w-24 h-24 mb-2 5 rounded-full shadow-lg"/>
                    @endif

                    <h5 class="mb-1 text-xl font-medium text-gray-900 " >
                        {{$user->name}}
                    </h5>
                    <span class="text-sm text-gray-500">{{$user->email}} </span>

                    <div class="flex mt-4 space-x-3 md:mt-6">

         

                        <x-primary-button wire:click="message({{$user->id}})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots mr-1" viewBox="0 0 16 16">
                                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                            </svg>
                            Message Now!
                        </x-primary-button>

                    </div>

                </div>


            </div>

        @endforeach
    </div>


</div>