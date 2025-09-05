<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.navbar-items.index') }}" 
               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-200 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Create Navbar Item
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            
            <!-- Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-plus-circle mr-2"></i> New Navigation Item
                </h3>
            </div>

            <!-- Form -->
            <div class="p-6">
                <form action="{{ route('admin.navbar-items.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="text-indigo-600">*</span> Title
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                          dark:bg-gray-700 dark:text-white transition duration-150"
                                   placeholder="Home">
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="text-indigo-600">*</span> Slug
                            </label>
                            <div class="relative mt-1">
                                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                       class="block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                              focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                              dark:bg-gray-700 dark:text-white transition duration-150"
                                       placeholder="home">
                                <button type="button" onclick="generateSlug()"
                                        class="absolute right-3 top-2.5 text-indigo-600 dark:text-indigo-400 
                                               hover:text-indigo-800 dark:hover:text-indigo-200">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Parent Item -->
                        <div>
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Parent Item
                            </label>
                            <select name="parent_id" id="parent_id"
                                    class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                           focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                           dark:bg-gray-700 dark:text-white transition duration-150">
                                <option value="">None (Top Level)</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                                   class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                          dark:bg-gray-700 dark:text-white transition duration-150">
                        </div>

                        <!-- Route Name -->
                        <div>
                            <label for="route" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Route Name</label>
                            <input type="text" name="route" id="route" value="{{ old('route') }}"
                                   class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                          dark:bg-gray-700 dark:text-white transition duration-150"
                                   placeholder="home.index">
                        </div>

                        <!-- Custom URL -->
                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custom URL</label>
                            <input type="text" name="url" id="url" value="{{ old('url') }}"
                                   class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                          dark:bg-gray-700 dark:text-white transition duration-150"
                                   placeholder="/home">
                        </div>

                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon Class</label>
                            <input type="text" name="icon" id="icon" value="{{ old('icon') }}"
                                   class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                                          focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                                          dark:bg-gray-700 dark:text-white transition duration-150"
                                   placeholder="fas fa-home">
                        </div>
                    </div>

                    <!-- Toggles -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="is_dropdown" value="0">
                            <input type="checkbox" name="is_dropdown" id="is_dropdown" value="1" {{ old('is_dropdown') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                            <label for="is_dropdown" class="text-sm text-gray-700 dark:text-gray-300">Is Dropdown</label>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="is_footer" value="0">
                            <input type="checkbox" name="is_footer" id="is_footer" value="1" {{ old('is_footer') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                            <label for="is_footer" class="text-sm text-gray-700 dark:text-gray-300">Show in Footer</label>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded">
                            <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Is Active</label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end pt-6">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg font-semibold text-white hover:from-indigo-600 hover:to-purple-600 shadow-lg">
                    <i class="fas fa-save mr-2"></i> Create Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Slug Generator -->
    <script>
        function generateSlug() {
            const title = document.getElementById('title').value;
            if (title) {
                const slug = title.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                document.getElementById('slug').value = slug;
            }
        }
        document.getElementById('title').addEventListener('input', function() {
            if (!document.getElementById('slug').value) {
                generateSlug();
            }
        });
    </script>
</x-app-layout>
