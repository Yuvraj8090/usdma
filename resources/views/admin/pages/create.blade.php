<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create New Page
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-file-alt mr-2"></i> Page Details
                </h3>
            </div>
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 font-medium border border-green-300">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 font-medium border border-red-300">
                    <i class="fas fa-exclamation-triangle mr-2"></i>There were some errors with your submission:
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('admin.pages.create') }}" method="POST" class="p-6">
                @csrf

                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-heading mr-1 text-indigo-500"></i> Title
                        </label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter page title">
                    </div>
                    <div>
                        <label for="title_hi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-heading mr-1 text-indigo-500"></i> Title hi
                        </label>
                        <input type="text" name="title_hi" id="title_hi" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter page title">
                    </div>

                    <!-- English Content -->
                    <div>
                        <label for="body_eng" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-language mr-1 text-blue-500"></i> Content (English)
                        </label>
                        <textarea name="body_eng" id="body_eng" rows="10" required
                            class="tinymce-editor w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter content in English">{{ old('body_eng') }}</textarea>
                    </div>

                    <!-- Hindi Content -->
                    <div>
                        <label for="body_hindi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-language mr-1 text-green-500"></i> Content (Hindi)
                        </label>
                        <textarea name="body_hindi" id="body_hindi" rows="10" required
                            class="tinymce-editor w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter content in Hindi">{{ old('body_hindi') }}</textarea>
                    </div>




                    <!-- SEO Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                            <i class="fas fa-search mr-2 text-purple-500"></i> SEO Settings
                        </h4>

                        <div class="space-y-4">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Meta Title
                                </label>
                                <input type="text" name="meta_title" id="meta_title"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                    placeholder="Optional meta title for SEO">
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Meta Description
                                </label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                    placeholder="Optional meta description for SEO"></textarea>
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Meta Keywords
                                </label>
                                <input type="text" name="meta_keywords" id="meta_keywords"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                    placeholder="Optional, comma separated keywords">
                            </div>
                        </div>
                    </div>

                    <!-- Status Toggle -->
                    <div class="flex items-center">
                        <div
                            class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="status"
                                {{ old('status', $page->status ?? '') === 'active' ? 'checked' : '' }}>

                            <label for="status"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-200"></label>
                        </div>
                        <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                            Active Page
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gray-700 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i> Create Page
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TinyMCE CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/skins/ui/oxide/content.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/skins/ui/oxide/skin.min.css">

    <style>
        .toggle-checkbox:checked {
            right: 0;
            border-color: #6366f1;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #6366f1;
        }

        /* TinyMCE Custom Styling */
        .tox-tinymce {
            border-radius: 0.5rem !important;
            border-color: #d1d5db !important;
        }

        .tox .tox-toolbar__primary {
            background: #f9fafb !important;
            border-bottom: 1px solid #e5e7eb !important;
        }

        .tox .tox-edit-area {
            background: #fff !important;
        }

        .dark .tox-tinymce {
            border-color: #4b5563 !important;
        }

        .dark .tox .tox-toolbar__primary {
            background: #1f2937 !important;
            border-bottom: 1px solid #374151 !important;
        }

        .dark .tox .tox-edit-area {
            background: #111827 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '.tinymce-editor',
                promotion: false,
                branding: false,
                menubar: false,
                plugins: 'link lists table code help',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table | code help',
                skin: 'oxide',
                content_css: 'default',
                setup: function(editor) {
                    editor.on('change', function() {
                        editor.save(); // Sync content to textarea
                    });
                }
            });
        });
    </script>

</x-app-layout>
