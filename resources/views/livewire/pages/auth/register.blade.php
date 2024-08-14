<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads; // Import the trait

new #[Layout('layouts.guest')] class extends Component
{
    use WithFileUploads; // Use the trait

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $avatar; // New property for avatar

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255','min:3'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'max:2048'], 
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        if (isset($validated['avatar'])) {
            $extension = $this->avatar->getClientOriginalExtension(); 
            $uniqueId = Str::random(10); // MS - Generate a random unique string
            $avatarName = "users-{$user->id}-{$uniqueId}.{$extension}";

            // MS - Store the avatar with the new name
            $avatarPath = $this->avatar->storeAs('avatars', $avatarName, 'public');
            $user->update(['avatar' => $avatarPath]); // MS - Update the user with the avatar path
        }

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('chat.index', absolute: false), navigate: true);
    }
}; ?>

<div>
    <form wire:submit.prevent="register" enctype="multipart/form-data">
        <!-- Name -->
        <x-app-title/>
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name"  autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email"  autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Avatar Upload -->
        <div class="mt-4">
            <x-input-label for="avatar" :value="__('Avatar (Optional)')" />
            <input wire:model="avatar" class="rounded-md shadow-sm relative m-0 block w-full min-w-0 flex-auto border border-solid border-secondary-500 bg-neutral-200 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-surface/50 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.52rem] file:text-surface/50 focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none dark:border-white/70 dark:bg-neutral-600  dark:text-white/50 file:dark:text-white/50" type="file" id="formFileDisabled"/>            
            <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
            @if ($avatar)
                <div class="mt-2">
                    <span class="text-sm text-gray-600">Preview:</span>
                    <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar Preview" class="mt-1 w-20 h-20 rounded-full object-cover border border-gray-300 shadow-sm">
                </div>
            @endif
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                             autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"  autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                <x-spinner/>
                <span class="sr-only">Loading...</span>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>
