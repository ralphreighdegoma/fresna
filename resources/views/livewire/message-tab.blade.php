<div x-data="{ selectedThread: {{ json_encode($active_thread) }}}">
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
                            :class="selectedThread.id == {{ $thread->id }} ? 'bg-blue-300 text-black' : 'bg-white hover:bg-gray-300 text-black'"
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
                <template x-if="selectedThread && selectedThread.last_message">
                    <div class="flex-1 overflow-y-auto px-4" >
                        <div class="mx-4" >
                            <div class="border p-4 rounded-lg">
                                <div class="mb-2">
                                    <strong x-text="selectedThread.last_message.sender.name"></strong>
                                    <span class="text-gray-500" x-text="selectedThread.last_message.date"></span>
                                </div>
                                <div>
                                    <p x-text="selectedThread.last_message.body"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>



                <!-- Reply box always stays at the bottom -->
                <div class="mt-auto">
                    @if(isset($active_thread))
                        @livewire('reply-box', [
                            'thread_id' => $active_thread->id, 'receiver_id' => $active_thread->other_user_id
                        ], key($active_thread->id))
                    @endif
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
