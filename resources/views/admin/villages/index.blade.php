<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Villages
        </h2>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">

            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-location-dot mr-1"></i> Manage Villages
            </div>

            <a href="{{ route('admin.villages.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-700 rounded-lg font-semibold text-white uppercase shadow-lg hover:from-indigo-600 hover:to-purple-600 transition-all">
                <i class="fas fa-plus-circle mr-2"></i> Create Village
            </a>

            <div x-data="{ open: false }">
                <button @click="open = !open"
                    class="inline-flex items-center px-4 py-2 bg-gray-700 rounded-lg font-semibold text-white uppercase shadow-lg hover:from-indigo-600 hover:to-purple-600 transition-all">
                    <i class="fas fa-filter mr-2"></i> Filters
                    <i :class="open ? 'fas fa-chevron-up ml-2' : 'fas fa-chevron-down ml-2'"></i>
                </button>

                <div x-show="open" x-transition
                    class="mt-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border dark:border-gray-700">

                    <form method="GET" action="{{ route('admin.villages.index') }}"
                        class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search villages..." class="w-full px-3 py-2 rounded-lg dark:bg-gray-900 border">

                        <select name="status" class="w-full px-3 py-2 rounded-lg dark:bg-gray-900 border">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <select name="tehsil_id" class="w-full px-3 py-2 rounded-lg dark:bg-gray-900 border">
                            <option value="">All Tehsils</option>
                            @foreach($tehsils as $t)
                                <option value="{{ $t->id }}" {{ request('tehsil_id') == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="per_page" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-lg dark:bg-gray-900 border">
                            @foreach([10,25,50,100] as $size)
                                <option value="{{ $size }}" {{ request('per_page',10)==$size ? 'selected':'' }}>
                                    Show {{ $size }}
                                </option>
                            @endforeach
                        </select>

                        <button class="px-4 py-2 bg-gray-700 rounded-lg text-white">
                            Apply
                        </button>

                    </form>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-700 dark:bg-green-800 dark:text-green-100">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white"><i class="fas fa-location-dot mr-2"></i> All Villages</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Village</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase">Tehsil</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y dark:divide-gray-700">
                        @forelse($villages as $v)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                                <td class="px-6 py-4">{{ $v->name }}</td>
                                <td class="px-6 py-4">{{ $v->tehsil->name }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($v->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Active</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">

                                    <a href="{{ route('admin.villages.edit', $v->id) }}"
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.villages.destroy', $v->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Delete this village?')"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg shadow hover:bg-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No villages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                {{ $villages->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
