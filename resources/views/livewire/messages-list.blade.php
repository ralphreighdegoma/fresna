<div>
    <div class="container mx-auto p-6">
        <!-- Messages List -->
        <div class="flex justify-end p-6">
            <x-filament::button
                tag="a"
                href="{{ url('/app/compose') }}"
                color="primary"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 focus:outline-none"
            >
                Compose
            </x-filament::button>

        </div>
        <div class="bg-white shadow-md rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left bg-gray-100 border-b">
                            <th class="px-6 py-3">#</th>
                            <th class="px-6 py-3">Star</th>
                            <th class="px-6 py-3">Message</th>
                            <th class="px-6 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr class="border-b hover:bg-gray-50">
                                <!-- Checkbox -->
                                <td class="px-6 py-3">
                                    <input type="checkbox" class="form-checkbox h-5 w-5">
                                </td>

                                <!-- Star -->
                                <td class="px-6 py-3">
                                    <button wire:click="toggleStar({{ $message->id }})">
                                        @if(in_array($message->id, $starredMessages))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927a1 1 0 011.902 0l1.356 4.198a1 1 0 00.95.69h4.421a1 1 0 01.592 1.805l-3.58 2.599a1 1 0 00-.364 1.118l1.356 4.198a1 1 0 01-1.54 1.118L10 15.427l-3.68 2.667a1 1 0 01-1.54-1.118l1.356-4.198a1 1 0 00-.364-1.118L2.191 9.62a1 1 0 01.592-1.805h4.421a1 1 0 00.95-.69l1.356-4.198z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927a1 1 0 011.902 0l1.356 4.198a1 1 0 00.95.69h4.421a1 1 0 01.592 1.805l-3.58 2.599a1 1 0 00-.364 1.118l1.356 4.198a1 1 0 01-1.54 1.118L10 15.427l-3.68 2.667a1 1 0 01-1.54-1.118l1.356-4.198a1 1 0 00-.364-1.118L2.191 9.62a1 1 0 01.592-1.805h4.421a1 1 0 00.95-.69l1.356-4.198z" />
                                            </svg>
                                        @endif
                                    </button>
                                </td>

                                <!-- Message Preview (cut-off) -->
                                <td class="px-6 py-3">
                                    {{ Str::limit($message->message, 100) }}
                                </td>

                                <!-- Date Sent -->
                                <td class="px-6 py-3">
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            Pagination
            <div class="px-6 py-3">
            </div>
        </div>
    </div>

</div>
