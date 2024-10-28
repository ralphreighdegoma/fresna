<x-filament::page>
    <div x-data="{ selectedNote: {{ json_encode($notes[0] ?? null) }}, isEditing: false }" class="grid grid-cols-3 gap-6 bg-gray-100 pt-4">

        <!-- Sidebar for Note Titles -->
        <div class="bg-gray-100 p-4">
            <h2 class="font-semibold text-lg mb-4">Notes</h2>
            <ul class="h-96 overflow-y-auto">
                @foreach ($notes as $noteItem)
                    <li class="mb-2">
                        <div
                            class="p-4 shadow rounded cursor-pointer"
                            x-on:click="selectedNote = {{ json_encode($noteItem) }}; isEditing = false"
                            :class="selectedNote.id == {{ $noteItem['id'] }} ? 'bg-blue-300 text-black' : 'bg-white hover:bg-gray-300 text-black'"
                        >
                            <h4 class="font-bold">{{ $noteItem['title'] }}</h4>
                            <p class="text-sm text-gray-500">{{ $noteItem['readable_created_at'] }}</p>
                            <p class="text-gray-600 truncate">{{ $noteItem['mini_content'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Main Content for Selected Note -->
        <div class="col-span-2 bg-white p-8 shadow rounded relative">
            <template x-if="selectedNote">
                <div class="grid grid-cols-3 gap-6 ">
                    <!-- Content Display and Edit Form -->
                    <div class="col-span-2">
                        <template x-if="!isEditing">
                            <div>
                                <h2 class="font-semibold text-2xl" x-text="selectedNote.title"></h2>
                                <p class="text-gray-500 mb-6" x-text="selectedNote.readable_created_at"></p>
                                <p class="text-gray-700 leading-relaxed" x-text="selectedNote.content"></p>
                            </div>
                        </template>

                        <template x-if="isEditing">
                            <!-- Form for Updating the Note -->
                            <form wire:submit.prevent="saveNote(selectedNote)">
                                <div class="mb-2">
                                    <x-filament::input.wrapper>
                                        <x-filament::input
                                            label="Title"
                                            name="title"
                                            x-model="selectedNote.title"
                                            class="w-full p-2 border rounded" />
                                    </x-filament::input.wrapper>
                                </div>

                                <div class="mb-2">
                                    <textarea
                                        name="content"
                                        id="content"
                                        x-model="selectedNote.content"
                                        rows="6"
                                        class="w-full p-2 border rounded"></textarea>
                                </div>
                                <!-- Save Button -->
                                <button type="submit" class="bg-purple-500 text-white py-2 px-4 rounded mt-4">Save</button>
                                <button type="button" class="bg-yellow-500 text-white py-2 px-4 rounded mt-4" x-on:click="isEditing = false">Cancel</button>
                            </form>
                        </template>


                    </div>
                    <div class="col-span-1">
                        <!-- Form Section with Edit Button -->
                        <template x-if="!isEditing">
                            <button type="button"
                                    x-on:click="isEditing = !isEditing"
                                    class="bg-purple-500 text-white py-1 px-2 rounded mb-2 absolute top-0 right-0">
                                <span>Edit Contents</span>
                            </button>
                        </template>
                        <!-- Set Reminder -->
                        <div class="mb-4" x-show="selectedNote.attachments && selectedNote.attachments.length" x-show="isEditing">
                            <h4 class="font-semibold text-lg mb-2">Set Reminder</h4>
                            <x-filament::input.wrapper>
                                <x-filament::input
                                    label="Date"
                                    type="date"
                                    name="reminder_date"
                                    x-model="selectedNote.reminder_date"
                                    class="w-full p-1 border rounded" />
                            </x-filament::input.wrapper>
                        </div>
                        <!-- Attachments -->
                        <div x-show="selectedNote.attachments && selectedNote.attachments.length">
                            <h4 class="font-semibold text-lg mb-2">Attachments</h4>
                            <ul class="flex space-x-4 truncate">
                                <template x-for="attachment in selectedNote.attachments" :key="attachment">
                                    <li>
                                        <a :href="attachment" class="text-blue-600 underline " x-text="attachment.substring(0, 10) + '...'"></a>
                                    </li>
                                </template>
                            </ul>
                            <template x-if="isEditing">
                                <button type="button"
                                        class="bg-gray-500 text-white py-0 px-1 rounded mt-2 mb-2">
                                    <span>Add attachments</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="!selectedNote">
                <p>Select a note to view details.</p>
            </template>
        </div>
    </div>
</x-filament::page>
