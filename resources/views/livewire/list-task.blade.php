@foreach ($items as $item)
    <div class="space-y-4">
        <div class="flex items-center text-xs">
            <div class="w-16 truncate text-white rounded-tl-md rounded-bl-md p-2" style="background-color: red;">
                <span>{{$item['date_created']}}</span>
            </div>
            <div class="flex-grow bg-gray-100 rounded-md p-2">
                <p>{{$item['title']}}</p>
            </div>
        </div>
    </div>
@endforeach
