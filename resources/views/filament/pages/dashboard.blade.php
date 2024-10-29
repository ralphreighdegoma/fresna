<x-filament-panels::page>
    <div>
        <div class="grid grid-cols-3 space-x-8">
            <!-- Upcoming Tasks Section -->
            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Upcoming Tasks</h2>
                @livewire('list-task')
            </div>

            <!-- Notifications Section -->
            <div class="col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Notifications</h2>
                @livewire('notes.list-notes')
            </div>

        </div>

        <div class="grid grid-cols-3 space-x-8 mt-4">
            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                @livewire(\App\Livewire\CoursePieChart::class)
            </div>

            <div class="col-span-2 bg-white rounded-lg shadow p-6">
                @livewire(\App\Livewire\CourseBarChart::class)
            </div>
        </div>

        <div class="grid grid-cols-3 space-x-8 mt-4">
            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                @livewire(\App\Livewire\CoursePieChartLess1Months::class)
            </div>

            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                @livewire(\App\Livewire\CoursePieChartLess3Months::class)
            </div>

            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                @livewire(\App\Livewire\CoursePieChartPlus6Months::class)
            </div>
        </div>

        <div class="grid grid-cols-3 space-x-8 mt-4">
            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">My Documents</h2>
                @livewire('list-courses')
            </div>

            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">My Saved Library</h2>
                @livewire('list-courses')
            </div>

            <div class="col-span-1 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">My Courses</h2>
                @livewire('list-courses')
            </div>
        </div>
    </div>
</x-filament-panels::page>
