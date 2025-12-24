<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Role Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.roles.edit', $role->id) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow transition-colors">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <a href="{{ route('admin.roles.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Roles
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <!-- Header Section -->
                <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700 border-b dark:border-gray-600">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200">Role Information</h3>
                </div>
                
                <!-- Details Section -->
                <div class="px-6 py-4 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Role Name</p>
                            <p class="text-lg text-gray-800 dark:text-gray-200">{{ $role->name }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</p>
                            <p class="text-lg text-gray-800 dark:text-gray-200">{{ $role->created_at->format('M d, Y') }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</p>
                            <p class="text-lg text-gray-800 dark:text-gray-200">{{ $role->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</p>
                        <p class="text-lg text-gray-800 dark:text-gray-200">{{ $role->description ?? 'No description provided' }}</p>
                    </div>
                </div>
                
                <!-- Users with this Role Section -->
                <div class="px-6 py-4 border-t dark:border-gray-700">
                    <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-4">Users with this Role</h4>
                    
                    @if($role->users && $role->users->count() > 0)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($role->users as $user)
                                    <div class="bg-white dark:bg-gray-600 p-3 rounded-lg shadow">
                                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 italic">No users assigned to this role.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>