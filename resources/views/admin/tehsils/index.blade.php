<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tehsils
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-map-marker-alt mr-1"></i> Manage Tehsils
            </div>

            <a href="{{ route('admin.tehsils.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-700 
               border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest 
               hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i> Create New Tehsil
            </a>

            <div x-data="{ open: false }">
                <button @click="open = !open"
                        class="inline-flex items-center px-4 py-2 bg-gray-700 
                        border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest 
                        hover:from-indigo-600 hover:to-purple-600 transition-all duration-200 shadow-lg">
                    <span><i class="fas fa-filter mr-2"></i> Filters</span>
                    <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                </button>

                <div x-show="open" x-transition
                     class="mt-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('admin.tehsils.index') }}"
                          class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <!-- Search -->
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search tehsils..."
                               class="w-full px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-white">

                        <!-- Status filter -->
                        <select name="status"
                                class="w-full px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-white">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status')==='active' ? 'selected':'' }}>Active</option>
                            <option value="inactive" {{ request('status')==='inactive' ? 'selected':'' }}>Inactive</option>
                        </select>

                        <!-- District filter -->
                        <select name="district_id"
                                class="w-full px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-white">
                            <option value="">All Districts</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                    {{ $district->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Per page -->
                        <select name="per_page"
                                class="w-full px-3 py-2 rounded-lg border dark:bg-gray-900 dark:text-white"
                                onchange="this.form.submit()">
                            @foreach ([10,25,50,100] as $size)
                                <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected':'' }}>
                                    Show {{ $size }}
                                </option>
                            @endforeach
                        </select>

                        <div>
                            <button type="submit"
                                    class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg shadow">
                                <i class="fas fa-filter mr-1"></i> Apply
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            </div>
        @endif


        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i> All Tehsils
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">District</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($tehsils as $tehsil)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="px-6 py-4">{{ $tehsil->name }}</td>
                                <td class="px-6 py-4">{{ $tehsil->district->name ?? '-' }}</td>

                                <td class="px-6 py-4 text-center">
                                    @if($tehsil->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Inactive</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.tehsils.edit',$tehsil->id) }}"
                                       class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.tehsils.destroy',$tehsil->id) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Are you sure?')" type="submit"
                                                class="px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No tehsils found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                {{ $tehsils->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
