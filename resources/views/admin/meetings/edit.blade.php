<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit Meeting</h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success message -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('admin.meetings.update', $meeting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                        <input type="date" name="date" value="{{ old('date', $meeting->date->format('Y-m-d')) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Time -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Time</label>
                        <input type="time" name="time" value="{{ old('time', $meeting->time->format('H:i')) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Meeting Location -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Meeting Location</label>
                        <input type="text" name="meeting_location" value="{{ old('meeting_location', $meeting->meeting_location) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('meeting_location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Topic -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Topic</label>
                        <input type="text" name="topic" value="{{ old('topic', $meeting->topic) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('topic') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Remark / Abhiyoukti -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Remark</label>
                        <input type="text" name="abhiyoukti" value="{{ old('abhiyoukti', $meeting->abhiyoukti) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('abhiyoukti') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Meeting URL -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Meeting URL</label>
                        <input type="url" name="meeting_url" value="{{ old('meeting_url', $meeting->meeting_url) }}" 
                               placeholder="https://example.com/meeting"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        @error('meeting_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">File / Document</label>
                        @if($meeting->file_url)
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.$meeting->file_url) }}" target="_blank" class="text-indigo-600 hover:underline">Current File</a>
                            </div>
                        @endif
                        <input type="file" name="file_url" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Allowed: pdf, doc, docx, jpg, png | Max: 2MB</p>
                        @error('file_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" 
                            class="px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-lg font-semibold hover:from-yellow-500 hover:to-yellow-600 transition-all duration-200 shadow">
                        Update Meeting
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
