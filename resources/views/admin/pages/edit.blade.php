<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Page
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit Page Details
                </h3>
            </div>
            
            <!-- Flash Messages -->
            @if (session('success'))
            <div class="m-4 p-4 rounded-lg bg-green-100 text-green-800 font-medium border border-green-300">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="m-4 p-4 rounded-lg bg-red-100 text-red-800 font-medium border border-red-300">
                <i class="fas fa-exclamation-triangle mr-2"></i>There were some errors with your submission:
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" class="p-6" data-turbo="false">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-heading mr-1 text-indigo-500"></i> Title
                        </label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter page title" value="{{ old('title', $page->title) }}">
                    </div>
                    <div>
                        <label for="title_hi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-heading mr-1 text-indigo-500"></i> Title Hi
                        </label>
                        <input type="text" name="title_hi" id="title_hi" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter page title" value="{{ old('title_hi', $page->title_hi) }}">
                    </div>
                    
                    <!-- Slug Field -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-link mr-1 text-blue-500"></i> Slug
                        </label>
                        <input type="text" name="slug" id="slug" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter URL slug" value="{{ old('slug', $page->slug) }}">
                    </div>
                    
                    <!-- English Content -->
                    <div>
                        <label for="body_eng" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-language mr-1 text-blue-500"></i> Content (English)
                        </label>
                        <textarea name="body_eng" id="body_eng" rows="10" required
                            class="tinymce-editor w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter content in English">{{ old('body_eng', $page->body_eng) }}</textarea>
                    </div>

                    <!-- Hindi Content -->
                    <div>
                        <label for="body_hindi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            <i class="fas fa-language mr-1 text-green-500"></i> Content (Hindi)
                        </label>
                        <textarea name="body_hindi" id="body_hindi" rows="10" required
                            class="tinymce-editor w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white transition duration-200"
                            placeholder="Enter content in Hindi">{{ old('body_hindi', $page->body_hindi) }}</textarea>
                    </div>
                    
                    <!-- SEO Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4 flex items-center">
                            <i class="fas fa-search mr-2 text-purple-500"></i> SEO Settings
                        </h4>
                        
                        <div class="space-y-4">
                            <!-- Meta Title -->
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Meta Title
                                </label>
                                <input type="text" name="meta_title" id="meta_title"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                    placeholder="Optional meta title for SEO" value="{{ old('meta_title', $page->meta_title) }}">
                            </div>
                            
                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Meta Description
                                </label>
                                <textarea name="meta_description" id="meta_description" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                    placeholder="Optional meta description for SEO">{{ old('meta_description', $page->meta_description) }}</textarea>
                            </div>
                            
                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Meta Keywords
                                </label>
                                <input type="text" name="meta_keywords" id="meta_keywords"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition duration-200"
                                    placeholder="Optional, comma separated keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}">
                            </div>
                        </div>
                    </div>
                    
<!-- Status Toggle (Visible only for role_id 1 or 2) -->
@if(in_array(auth()->user()->role_id, [1, 2]))
    <div class="flex items-center">
        <!-- Hidden input ensures '0' is submitted when unchecked -->
        <input type="hidden" name="status" value="0">

        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
            <input type="checkbox" name="status" id="status" value="1"
                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"
                {{ old('status', $page->status) == '1' ? 'checked' : '' }}>
        </div>
        <label for="status" class="text-sm font-medium text-gray-700 dark:text-gray-300">
            Active Page
        </label>
    </div>
@endif


                    
                    <!-- Submit Button -->
                    <div class="pt-4 flex justify-between">
                        <button type="submit" 
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save mr-2"></i> Update Page
                        </button>
                        
                        <a href="{{ route('admin.pages.list') }}" 
                            class="inline-flex items-center px-6 py-3 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-lg font-semibold text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow hover:shadow-md">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Pages
                        </a>
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
        .toggle-checkbox:checked + .toggle-label {
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
        document.addEventListener('DOMContentLoaded', function () {
            tinymce.init({
                selector: '.tinymce-editor',
                promotion: false,
                branding: false,
                menubar: false,
                plugins: 'link lists table code help',
                toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table | code help',
                skin: 'oxide',
                content_css: 'default',
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save(); // Sync content to textarea
                    });
                }
            });
        });
    </script>
</x-app-layout>