<div class="flex items-start p-4 bg-white rounded-lg shadow">
    <div class="w-1/4">
        <h4 class="font-bold">{{ $getRecord()->title }}</h4>
        <p class="text-sm text-gray-600">{{ $getRecord()->created_at->format('m/d/Y') }}</p>
        <p class="text-sm">{{ Str::limit($getRecord()->content, 100) }}</p>
    </div>
    <div class="w-3/4 pl-4">
        <p class="text-gray-800">{{ $getRecord()->content }}</p>
        {{-- Check if attachments exist --}}
        <div class="flex space-x-2">
            @if ($getRecord()->attachments && $getRecord()->attachments->isNotEmpty())
                @foreach($getRecord()->attachments as $attachment)
                    <a href="{{ $attachment->url }}" class="text-blue-500">{{ $attachment->name }}</a>
                @endforeach
            @else
                <p>No attachments available</p>
            @endif
        </div>
    </div>
</div>
