<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Media Files
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-file-alt mr-1"></i> Manage your media files
            </div>
            <a href="{{ route('admin.media-files.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i> Upload New File
            </a>
        </div>

        <!-- Success Toast -->
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded-lg shadow">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if ($mediaFiles->isEmpty())
            <div class="text-center text-gray-500 dark:text-gray-400 py-10">
                No media files found.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($mediaFiles as $file)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 p-4 flex flex-col justify-between">
                        <div class="flex-1">
                            <!-- Preview -->
                            <div class="mb-4 flex justify-center items-center bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden"
                                style="max-width: 300px; max-height: 200px;">
                                @if (str_contains($file->mime_type, 'image'))
                                    <img src="{{ Storage::url($file->file_path) }}" alt="{{ $file->name }}"
                                        class="object-contain w-full h-full">
                                @elseif(str_contains($file->mime_type, 'pdf'))
                                    <iframe src="{{ Storage::url($file->file_path) }}" class="w-full h-full"
                                        style="border:none;" title="{{ $file->name }}"></iframe>
                                @else
                                    <i class="fas fa-file-alt text-4xl text-gray-400 dark:text-gray-300"></i>
                                @endif
                            </div>

                            <!-- File Info -->
                            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                                {{ $file->name }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $file->mime_type }} |
                                {{ number_format($file->size / 1024, 2) }} KB
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex justify-between space-x-1">
                            <a href="{{ route('admin.media-files.download', $file->id) }}"
                                class="flex-1 inline-flex justify-center items-center px-3 py-1 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium rounded-lg transition-all duration-200">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>

                            <button type="button"
                                onclick="copyLink('{{ url(Storage::url($file->file_path)) }}')"
                                class="flex-1 inline-flex justify-center items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-lg transition-all duration-200">
                                <i class="fas fa-copy mr-1"></i> Copy
                            </button>

                            <form action="{{ route('admin.media-files.destroy', $file->id) }}" method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Are you sure you want to delete this file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex justify-center items-center px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-all duration-200">
                                    <i class="fas fa-trash mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $mediaFiles->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    <!-- Copy Link Script with Toast -->
    <script>
        function copyLink(link) {
            navigator.clipboard.writeText(link)
                .then(() => {
                    showToast('Link copied to clipboard!');
                })
                .catch(err => {
                    showToast('Failed to copy link.', true);
                    console.error(err);
                });
        }

        function showToast(message, isError = false) {
            let toast = document.createElement('div');
            toast.className =
                `fixed bottom-5 right-5 px-4 py-2 rounded-lg shadow-lg text-white text-sm font-medium z-50 transition-opacity duration-300 ${
                    isError ? 'bg-red-500' : 'bg-green-600'
                }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 2000);
        }
    </script>
</x-app-layout>
