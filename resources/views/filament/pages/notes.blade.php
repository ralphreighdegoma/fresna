<x-filament::page>
    <div x-data="{ selectedNote: {{ json_encode($notes[0] ?? null) }}, isEditing: false }" class="grid grid-cols-3 gap-6 bg-gray-100 pt-4">

        <!-- Sidebar for Note Titles -->
        <div class="bg-gray-100 p-4">
            <h2 class="font-semibold text-lg mb-4">Notes</h2>
            <ul class="h-96 overflow-y-auto">
                @foreach ($notes as $noteItem)
                    <li class="mb-2">
                        <div
                            class="bg-white p-4 shadow rounded cursor-pointer hover:bg-gray-50"
                            x-on:click="selectedNote = {{ json_encode($noteItem) }}; isEditing = false"
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
        <div class="col-span-2 bg-white p-8 shadow rounded">
            <template x-if="selectedNote">
                <div class="grid grid-cols-3 gap-6">

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
                            <div>
                                <!-- Title Input -->
                                <label class="block text-gray-700 mb-2">Title</label>
                                <input type="text" x-model="selectedNote.title" class="w-full p-2 border rounded mb-4" />

                                <!-- Content Markdown Editor -->
                                <label class="block text-gray-700 mb-2">Content</label>
                                <textarea x-model="selectedNote.content" class="w-full p-2 border rounded h-32"></textarea>
                            </div>
                        </template>

                        <!-- Attachments -->
                        <div x-show="selectedNote.attachments && selectedNote.attachments.length" class="mt-6">
                            <h4 class="font-semibold text-lg mb-2">Attachments</h4>
                            <ul class="flex space-x-4">
                                <template x-for="attachment in selectedNote.attachments" :key="attachment.id">
                                    <li>
                                        <a :href="attachment.url" class="text-blue-600 underline" x-text="attachment.filename"></a>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    <!-- Form Section with Edit Button -->
                    <div class="col-span-1">
                        <form>
                            <!-- Toggle Editing Mode -->
                            <button type="button"
                                    x-on:click="isEditing = !isEditing"
                                    class="bg-purple-500 text-white py-2 px-4 rounded mb-4">
                                <span x-text="isEditing ? 'Save' : 'Edit Contents'"></span>
                            </button>

                            <!-- Other Form Fields -->
                            <!-- Reminder Date -->
                            <div class="mb-4">
                                <label class="block text-gray-700">Set Reminder</label>
                                <input type="date" class="border rounded w-full py-2 px-3 text-gray-700">
                            </div>

                            <!-- Shared With -->
                            <div class="mb-4">
                                <label class="block text-gray-700">Shared with</label>
                                <select class="border rounded w-full py-2 px-3 text-gray-700 mb-2">
                                    <option>Select a user</option>
                                </select>
                                <div class="bg-gray-200 py-2 px-3 rounded mb-2">Firstname Lastname <span class="text-gray-500">x</span></div>
                            </div>

                            <!-- Attachments -->
                            <div class="mb-4">
                                <label class="block text-gray-700">Attachments</label>
                                <ul class="list-none mb-4">
                                    <li><a href="#" class="text-blue-600 underline">task_link.pdf</a></li>
                                </ul>
                                <button type="button" class="border rounded py-2 px-4 text-gray-700">Add attachments</button>
                            </div>

                            <!-- Link Resource -->
                            <div class="mb-4">
                                <label class="block text-gray-700">Link Resource</label>
                                <ul class="list-none mb-4">
                                    <li><a href="#" class="text-blue-600 underline">Resource_1.pdf</a></li>
                                </ul>
                                <button type="button" class="border rounded py-2 px-4 text-gray-700">Link Resource</button>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <template x-if="!selectedNote">
                <p>Select a note to view details.</p>
            </template>
        </div>
    </div>
</x-filament::page>
