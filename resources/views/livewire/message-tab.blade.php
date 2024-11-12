
<div x-data="{ selectedThread: {{ $active_thread ? json_encode($active_thread) : null }}, message: @entangle('message')}">
    <div class="flex space-x-4">
        <button wire:click="setActiveTab('messages')" class="{{ $activeTab === 'messages' ? 'font-bold' : '' }}">
            Inbox
        </button>
        <button wire:click="setActiveTab('notifications')" class="{{ $activeTab === 'notifications' ? 'font-bold' : '' }}">
            Notifications
        </button>
    </div>

    <div class="mt-4">
        @if ($activeTab === 'messages')

        <div class="p-4 border rounded flex h-screen">
            <div class="flex-none" style="max-width: 300px; width: 100%; max-height: calc(100vh - 2rem); overflow-y: auto;">
                <!-- <h2 class="text-xl">Messages</h2> -->
                <div class="flex flex-col gap-y-2">
                    @foreach ( $threads as $thread)
                        <div
                            class="max-w-xs h-52 rounded-lg cursor-pointer border border-b-1 overflow-hidden"
                            :class="selectedThread && selectedThread.id == {{ $thread->id }} ? 'bg-blue-300 text-black' : 'bg-white hover:bg-gray-300 text-black'"
                            x-on:click="selectedThread = {{ json_encode($thread) }}"
                            x-key="{{ $thread->id.'-'.isset($active_thread) ? $active_thread->id : '-' }}">
                            @livewire('message-side-holder', [
                                'name' => $thread->name,
                                'date' => $thread->date,
                                'message' => $thread->message,
                                'is_active' => true
                            ])
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex-1 ml-4 flex flex-col h-full">
                <!-- Message viewer should take up available space -->
                <template x-if="selectedThread">
                    <div class="flex-1 overflow-y-auto px-4" >
                        <div class="mx-4" >
                            <div class="border p-4 rounded-lg">
                                <div class="mb-2">
                                    <strong x-text="selectedThread.sender.name"></strong>
                                    <span class="text-gray-500" x-text="selectedThread.date"></span>
                                </div>
                                <div>
                                    <p x-text="selectedThread.body"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>



                <!-- Reply box always stays at the bottom -->
                <div class="mt-auto">
                    <template x-if="selectedThread">
                        <form wire:submit.prevent="sendMessage(selectedThread.sender_id,selectedThread.thread_id,message)">
                            <div class="flex flex-col p-4 border rounded shadow">
                                <div class="mb-2">
                                    <label for="message" class="block text-gray-700">Reply:</label>
                                    <textarea x-model="message" id="message" class="w-full h-32 border rounded focus:outline-none focus:ring focus:ring-blue-500"></textarea>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <button type="button" class="mr-2">
                                            <i class="fas fa-paperclip"></i> <!-- Attach icon -->
                                        </button>
                                    </div>
                                    <x-filament::button type="submit" class="bg-blue-500 hover:bg-blue-600">
                                        Send
                                    </x-filament::button>
                                </div>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>



        @elseif ($activeTab === 'notifications')
            <div class="p-4 border rounded">
                <h2 class="text-xl">Notifications</h2>
                <p>Your notifications will be displayed here.</p>
                <!-- Add your notifications logic here -->
            </div>
        @endif
    </div>
</div>
