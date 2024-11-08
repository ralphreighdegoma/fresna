<div class="p-4 bg-white rounded shadow" x-data="{ selectedTab: 'day'}">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-lg font-semibold">Timesheet</h1>
        <a href="{{route('filament.app.resources.time-sheets.create')}}" class="px-4 py-2 bg-purple-500 text-white rounded">+ New Entry</a>
    </div>

    <div class="flex items-center justify-between mb-4">
        <!-- Date Navigation -->
        <div class="flex items-center">
            <button class="py-1 px-3 rounded-md border border-gray-300  text-gray-600">&lt;</button>
            <button class="py-1 px-3 rounded-md border border-gray-300 text-gray-600 ">&gt;</button>
            <div class="pl-4">
                &nbsp;&nbsp;<span class="font-semibold">Today: Friday, 10 August</span>
            </div>
        </div>

        <!-- View Options -->
        <div class="flex space-x-2">
            <!-- <button class="px-4 py-2 rounded border border-gray-300 text-gray-600">Custom</button>
            <button class="px-4 py-2 rounded ">Week</button>
            <button class="px-4 py-2 rounded bg-purple-500 text-white">Day</button> -->
            <button
              class="px-4 py-2 rounded "
              :class="selectedTab === 'custom' ? 'bg-purple-500 text-white' : 'border border-gray-300 text-gray-600'"
              >
              Custom
            </button>
            <button
              class="px-4 py-2 rounded "
              :class="selectedTab === 'week' ? 'bg-purple-500 text-white' : 'border border-gray-300 text-gray-600'"
              x-on:click="selectedTab = 'week'">
              Week
            </button>
            <button
              class="px-4 py-2 rounded "
              :class="selectedTab === 'day' ? 'bg-purple-500 text-white' : 'border border-gray-300 text-gray-600'"
              x-on:click="selectedTab = 'day'">
              Day
            </button>
            </div>
    </div>

    <div x-show="selectedTab == 'day'">
        <div class="grid grid-cols-7 gap-2 mt-4 text-center bg-purple-500 rounded text-white">
            <div class="col-span-7 flex">
                @foreach ($entries as $entry)
                <div class="w-full p-2 bg-blue-100 rounded">
                    <div>{{ $entry['day'] }}</div>
                    <div>{{ $entry['hours'] }}</div>
                </div>
                @endforeach
                <div class="w-full p-2 bg-blue-200 rounded">
                    <div>Total</div>
                    <div>00:00</div>
                </div>
            </div>
        </div>
        @foreach ($time_sheets as $entry)
        <div class="p-4 bg-gray-300">
            <div class="rounded shadow p-4 bg-white">
                <div class="flex justify-between">
                    <h2 class="font-semibold">Timesheet Entry</h2>
                    <span class="float-right">{{$entry['time_readable']}}</span>
                </div>
                <p class="text-xs mt-2">{{$entry['client']['name']}}, {{$entry['category_title']}}, {{$entry['task']['title']}}</p>
                <p class="text-sm mt-3">{{$entry['comment']}}</p>
            </div>
        </div>
        @endforeach

    </div>

    <div x-show="selectedTab == 'week'">
        <div class="grid grid-cols-9 gap-2 mt-4 text-center bg-purple-500 rounded text-white">
            <div class="col-span-8 flex">
                <div class="w-full p-2 rounded"></div>
                @foreach ($entries as $entry)
                <div class="w-full p-2 rounded">
                    <div>{{ $entry['day'] }}</div>
                </div>
                @endforeach
                <div class="w-full p-2"></div>
            </div>
        </div>
        <div class="grid grid-cols-9 gap-2 mt-4 text-center">
            @foreach ($week_entries as $week)
                <div class="col-span-8 flex">
                    <div class="w-full p-2 bg-blue-200">
                        <div class="text-sm">{{$week['client']}}</div>
                        <div class="text-xs">{{$week['task']}}</div>
                    </div>
                    @foreach ($week['hours'] as $entry)
                        <div class="w-full p-2 bg-blue-100">
                            <div class="rounded border p-4">

                            </div>
                        </div>
                    @endforeach
                    <div class="w-full p-2 bg-blue-100">
                        <button class="text-red-500 text-xl font-semibold">×</button>
                    </div>
                </div>
            @endforeach

        </div>
        <div class="bg-gray-100 rounded" x-show="false">
            <!-- Header Row for Days of the Week -->
            <div class="grid grid-cols-8 text-center bg-blue-100 py-2">
                <div></div> <!-- Empty cell for client/task -->
                @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                    <div class="font-semibold">{{ $day }}<br>6 Aug</div>
                @endforeach
            </div>

            <!-- Rows for Each Entry -->
            @foreach ($week_entries as $entry)
            <div class="grid grid-cols-8 items-center py-2 border-b border-gray-200 text-center">
                <div class="px-2 text-left">
                    <div class="font-semibold">{{ $entry['client'] }}</div>
                    <div class="text-gray-500">{{ $entry['task'] }}</div>
                </div>
                @foreach ($entry['hours'] as $hour)
                    <input type="text" class="border rounded w-full py-1 text-center" value="{{ $hour }}">
                @endforeach
                <button class="text-red-500 text-xl font-semibold">×</button>
            </div>
            @endforeach

            <!-- Footer Row for Totals -->
            <div class="grid grid-cols-8 bg-gray-100 text-center py-2">
                <div></div> <!-- Empty cell for label -->
                @foreach (range(1, 7) as $i)
                    <div>0</div> <!-- Replace with total hours per day if needed -->
                @endforeach
            </div>
        </div>
    </div>
</div>
