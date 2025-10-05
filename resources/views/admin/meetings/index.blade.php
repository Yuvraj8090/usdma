<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Meetings
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-calendar-alt mr-1"></i> Manage your meetings
            </div>
            <a href="{{ route('admin.meetings.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Create Meeting
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Meetings Table Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i> All Meetings
                </h3>
            </div>

            <div class="overflow-x-auto p-4">
                <x-table.data-table
                    :id="'meetings-table'"
                    :headers="['Date', 'Time', 'Location', 'Topic', 'Abhiyoukti', 'File', 'Actions']"
                    :page-length="10"
                    :length-menu="[5, 10, 25, 50, -1]"
                    :length-menu-labels="['5', '10', '25', '50', 'All']"
                    title="Meetings Export"
                    search-placeholder="Search Meetings..."
                    resource-name="meetings"
                >
                    @foreach($meetings as $meeting)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meeting->date->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meeting->time->format('H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meeting->meeting_location }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meeting->topic }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $meeting->abhiyoukti }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($meeting->file_url)
                                <a href="{{ asset('storage/'.$meeting->file_url) }}" target="_blank" class="text-indigo-600 hover:underline">View File</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                            <a href="{{ route('admin.meetings.edit', $meeting->id) }}" 
                               class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-400 to-yellow-500 border border-transparent rounded-lg font-medium text-white hover:from-yellow-500 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-all duration-200 shadow">
                                <i class="fas fa-edit mr-1 text-xs"></i> Edit
                            </a>
                            <form action="{{ route('admin.meetings.destroy', $meeting->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 border border-transparent rounded-lg font-medium text-white hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow"
                                        onclick="return confirm('Are you sure you want to delete this meeting?')">
                                    <i class="fas fa-trash mr-1 text-xs"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </x-table.data-table>
            </div>
        </div>
    </div>
</x-app-layout>
