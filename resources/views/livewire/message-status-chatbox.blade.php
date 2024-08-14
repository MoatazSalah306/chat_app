<div>
   
    <div wire:poll.5s>

        @if ($message->read_at)
            {{-- double ticks --}}
            <span class="text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-check2-all" viewBox="0 0 16 16">
                    <path
                        d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z" />
                    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z" />
                </svg>
            </span>
        @else
            {{-- single ticks --}}
            <span class="text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                </svg>
            </span>
        @endif



    </div>

</div>
