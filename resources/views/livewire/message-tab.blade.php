<div>
    <div class="flex space-x-4">
        <button wire:click="setActiveTab('messages')" class="{{ $activeTab === 'messages' ? 'font-bold' : '' }}">
            Messages
        </button>
        <button wire:click="setActiveTab('notifications')" class="{{ $activeTab === 'notifications' ? 'font-bold' : '' }}">
            Notifications
        </button>
    </div>

    <div class="mt-4">
        @if ($activeTab === 'messages')
        
        <div class="p-4 border rounded flex h-screen">
            <div class="flex-none" style="max-width: 300px; width: 100%; max-height: calc(100vh - 2rem); overflow-y: auto;">
                <h2 class="text-xl">Messages</h2>
                @for($i = 0; $i < 10; $i++)
                    @livewire('message-side-holder', [
                        'name' => 'John Doe', 
                        'date' => '2024-10-20 15:30:00', 
                        'message' => 'This is a long message that should be cut off if it exceeds the available space in the box.'
                    ])
                @endfor
            </div>

            <div class="flex-1 ml-4 flex flex-col h-full">
                <!-- Message viewer should take up available space -->
                <div class="flex-1 overflow-y-auto">
                    @livewire('message-viewer', [
                        'senderName' => 'John Doe',
                        'date' => '2024-10-20',
                        'message' => 'This is a sample internal message for your reference.'
                    ])
                </div>
                
                <!-- Reply box always stays at the bottom -->
                <div class="mt-auto">
                    @livewire('reply-box')
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
