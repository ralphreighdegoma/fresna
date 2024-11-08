<div>
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

                            wire:click="setActiveThread({{ $thread->id }})">
                            @livewire('message-side-holder', [
                                'is_active' => isset($active_thread) && $thread->id === $active_thread->id,
                                'thread' => $thread,
                            ], key($thread->id.'-'.$active_thread->id))
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex-1 ml-4 flex flex-col h-full">
                <!-- Message viewer should take up available space -->
                <div class="flex-1 overflow-y-auto px-4">

                    @if(isset($active_thread) && isset($active_thread->messages) && count($active_thread->messages) > 0)
                        @foreach ( [$active_thread->last_message] as $message)
                            <div class="mx-4">
                                @livewire('message-viewer', [
                                    'senderName' => $message->sender->name,
                                    'date' => $message->date,
                                    'message' => $message->body,
                                    'is_sender' => $message->sender_id == $currentUserId
                                ], key($active_thread->id))
                            </div>
                        @endforeach
                    @endif
                </div>

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
