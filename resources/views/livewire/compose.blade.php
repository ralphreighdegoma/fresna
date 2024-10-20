<div>
    <div class="w-full mx-auto mt-8 p-6  shadow-md rounded-lg">
        <form wire:submit.prevent="sendMessage">
            <!-- Flash message -->
            @if (session()->has('success'))
                <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- To Field -->
            <div class="flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m4 0v8m4-8l-4-4-4 4" />
                </svg>
                <input wire:model="to" type="email" placeholder="To" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                @error('to') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Subject Field -->
            <div class="flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a3 3 0 013-3h2a3 3 0 013 3v4a3 3 0 013 3v4a3 3 0 01-3 3H8a3 3 0 01-3-3v-4a3 3 0 013-3z" />
                </svg>
                <input wire:model="subject" type="text" placeholder="Subject" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300">
                @error('subject') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Message Field -->
            <div class="flex items-start mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m7 4h-7m7-8h-7" />
                </svg>
                <textarea wire:model="message" placeholder="Write your message here..." rows="6" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300"></textarea>
                @error('message') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end">
                <x-filament::button
                    tag="a"
                    href="{{ url('/app/compose') }}"
                    color="primary"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 focus:outline-none"
                >
                    New Message
                </x-filament::button>
            </div>
        </form>
    </div>

</div>


