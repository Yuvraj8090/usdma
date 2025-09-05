<div class="flex flex-col h-full w-60 px-4 py-6 justify-between bg-white dark:bg-gray-800 transition-colors duration-300">

    <!-- Navigation Section -->
    <div>
        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-3 ml-2">
            Navigation
        </p>

        <!-- Toasts -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded-md flex items-center transition-colors">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-800 dark:border-red-600 dark:text-red-100 rounded-md flex items-center transition-colors">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="space-y-2">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
               {{ request()->routeIs('dashboard')
                    ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'
                    : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-home mr-3"></i>
                Dashboard
            </a>

            <!-- User Management -->
            <x-sidebar.dropdown 
                icon="fas fa-users" 
                label="User Management"
                :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*')">

                <x-sidebar.link route="admin.users.index" label="Users" :active="request()->routeIs('admin.users.*')" />
                <x-sidebar.link route="admin.roles.index" label="Roles" :active="request()->routeIs('admin.roles.*')" />
            </x-sidebar.dropdown>

            <!-- Reports -->
            <x-sidebar.dropdown 
                icon="fas fa-file-alt" 
                label="Reports"
                :active="request()->routeIs('admin.daily_reports.*') || request()->routeIs('admin.daily_reports_fillable.*') || request()->routeIs('admin.district-reports.*')">

                <x-sidebar.link route="admin.daily_reports.index" label="Daily Reports" :active="request()->routeIs('admin.daily_reports.*')" />
                <x-sidebar.link route="admin.daily_reports_fillable.index" label="Report Categories" :active="request()->routeIs('admin.daily_reports_fillable.*')" />
                <x-sidebar.link route="admin.district-reports.index" label="District Reports" :active="request()->routeIs('admin.district-reports.*')" />
            </x-sidebar.dropdown>

            <!-- Accidental Reports -->
            <x-sidebar.dropdown 
                icon="fas fa-car-crash" 
                label="Accidental Reports"
                :active="request()->routeIs('admin.accidental_reports.*') || request()->routeIs('admin.accidental-reports-fillable.*')">

                <x-sidebar.link route="admin.accidental_reports.index" label="Accident Reports" :active="request()->routeIs('admin.accidental_reports.*')" />
                <x-sidebar.link route="admin.accidental-reports-fillable.index" label="Report Categories" :active="request()->routeIs('admin.accidental-reports-fillable.*')" />
            </x-sidebar.dropdown>

            <!-- Locations -->
            <x-sidebar.dropdown 
                icon="fas fa-map-marker-alt" 
                label="Locations"
                :active="request()->routeIs('admin.states.*') || request()->routeIs('admin.districts.*') || request()->routeIs('admin.dhams.*') || request()->routeIs('admin.district-users.*')">

                <x-sidebar.link route="admin.states.index" label="States" :active="request()->routeIs('admin.states.*')" />
                <x-sidebar.link route="admin.districts.index" label="Districts" :active="request()->routeIs('admin.districts.*')" />
                <x-sidebar.link route="admin.district-users.index" label="District Assignments" :active="request()->routeIs('admin.district-users.*')" />
                <x-sidebar.link route="admin.dhams.index" label="Dhams" :active="request()->routeIs('admin.dhams.*')" />
            </x-sidebar.dropdown>

            <!-- Media Files -->
            <a href="{{ route('admin.media-files.index') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
               {{ request()->routeIs('admin.media-files.*')
                    ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'
                    : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-photo-video mr-3"></i>
                Media Files
            </a>

            <!-- Pages -->
            <a href="{{ route('admin.pages.list') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
               {{ request()->routeIs('admin.pages.*')
                    ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'
                    : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-file-contract mr-3"></i>
                Pages
            </a>

            <!-- Settings -->
            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
               {{ request()->routeIs('admin.settings.*')
                    ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'
                    : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-cog mr-3"></i>
                Settings
            </a>

            <!-- Navbar Items -->
            <a href="{{ route('admin.navbar-items.index') }}"
               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
               {{ request()->routeIs('admin.navbar-items.*')
                    ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'
                    : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                <i class="fas fa-bars mr-3"></i>
                Navbar Items
            </a>

            <!-- Clear Cache -->
            <form method="POST" action="{{ route('admin.clear.cache') }}" class="mt-3">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                        hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                    <i class="fas fa-broom mr-3"></i> Clear Cache
                </button>
            </form>
        </nav>
    </div>

    <!-- User Info Section -->
    <div class="mt-6">
        <div class="flex items-center p-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md transition-colors">
            <img class="h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Administrator</p>
            </div>
        </div>
    </div>
</div>
