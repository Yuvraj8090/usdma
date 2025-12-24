<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit District Report
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit Report
                </h3>
            </div>

            <form action="{{ route('admin.district-reports.update', $districtReport->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- District -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">District</label>
                    <select name="district_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ $districtReport->district_id == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('district_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Report Body -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Body</label>
                    <textarea name="body" rows="10" required
                        class="tinymce-editor w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm dark:bg-gray-700 dark:text-white transition duration-200">{{ old('body', $districtReport->body) }}</textarea>
                    @error('body') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Submit Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Submit Date</label>
                    <input type="date" name="submit_date" value="{{ old('submit_date', $districtReport->submit_date->format('Y-m-d')) }}" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200">
                    @error('submit_date') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Actions -->
                <div class="flex justify-end">
                    <a href="{{ route('admin.district-reports.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 mr-2">Cancel</a>
                    <button type="submit"
                        class="px-6 py-2 bg-gray-700 text-white rounded-lg shadow-lg hover:bg-indigo-700">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- TinyMCE Setup -->
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
                        editor.save();
                    });
                }
            });
        });
    </script>
</x-app-layout>
