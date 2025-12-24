<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Road Closed Categories
            </h2>
        </div>
    </x-slot>

    <div class="py-6 container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Top bar -->
        <div class="flex justify-between items-center mb-6">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <i class="fas fa-road mr-1"></i> Manage Road Closure Types (Bridge Damage, Landslide, etc.)
            </div>
            <a href="{{ route('admin.road-closed-fillable.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:from-green-600 hover:to-emerald-600 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus-circle mr-2"></i> Create Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-gray-700">
                <h3 class="text-lg font-medium text-white flex items-center">
                    <i class="fas fa-list mr-2"></i> All Road Closed Categories
                </h3>
            </div>

            <div class="overflow-x-auto p-4">
                @php
                    $headers = ['Name', 'Parent', 'Active', 'Actions'];
                @endphp

                <x-table.data-table
                    :id="'road-closed-categories-table'"
                    :headers="$headers"
                    :page-length="10"
                    :length-menu="[5,10,25,50,-1]"
                    :length-menu-labels="['5','10','25','50','All']"
                    title="Road Closed Categories Export"
                    search-placeholder="Search Categories..."
                    resource-name="road-closed-categories"
                >
                    @forelse($fillables as $fillable)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4">{{ $fillable->name }}</td>
                            <td class="px-6 py-4">{{ $fillable->parent?->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($fillable->is_active)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.road-closed-fillable.edit', $fillable->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.road-closed-fillable.destroy', $fillable->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete this category?')" class="px-3 py-1 bg-red-600 text-white rounded-lg shadow hover:bg-red-700">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        
                    @endforelse
                </x-table.data-table>
            </div>
        </div>
    </div>
</x-app-layout>
