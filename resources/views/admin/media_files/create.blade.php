<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Upload New Media File
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-800 dark:border-red-600 dark:text-red-100">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded-xl p-6">
                <form action="{{ route('admin.media-files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Select File</label>
                        <input type="file" name="file" id="file" 
                               class="block w-full text-sm text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Allowed file types: any. Max size: 10MB</p>
                    </div>

                    <div class="flex justify-end space-x-2 mt-6">
                        <a href="{{ route('admin.media-files.index') }}" 
                           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg shadow transition-all duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-gray-700 hover:from-indigo-600 hover:to-purple-600 text-white rounded-lg font-semibold shadow transition-all duration-200">
                            <i class="fas fa-upload mr-2"></i> Upload
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
