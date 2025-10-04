<div class="flex flex-col h-full w-60 px-4 py-6 justify-between bg-white dark:bg-gray-800 transition-colors duration-300">

    <!-- Navigation Header -->
    <div>
        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-3 ml-2">
            Navigation
        </p>

        <!-- Notifications -->
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded-md flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-800 dark:border-red-600 dark:text-red-100 rounded-md flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <nav class="space-y-2">

            {{-- Dashboard --}}
            <x-sidebar.link 
                route="dashboard" 
                label="Dashboard" 
                icon="fas fa-home" 
                :active="request()->routeIs('dashboard')" 
            />

            {{-- Admin Section --}}
            <x-sidebar.dropdown 
                icon="fas fa-user-shield" 
                label="Admin" 
                :active="request()->routeIs('admin.daily_reports_dhams.*')  || request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.accidental_reports.*')">

                {{-- User Management --}}
                <x-sidebar.dropdown 
                    icon="fas fa-users-cog" 
                    label="User Management" 
                    :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*')">

                    <x-sidebar.link 
                        route="admin.users.index" 
                        label="Users" 
                        icon="fas fa-user" 
                        :active="request()->routeIs('admin.users.*')" 
                    />
                    <x-sidebar.link 
                        route="admin.roles.index" 
                        label="Roles" 
                        icon="fas fa-user-tag" 
                        :active="request()->routeIs('admin.roles.*')" 
                    />
                </x-sidebar.dropdown>

                {{-- Accidental Reports --}}
                <x-sidebar.dropdown 
                    icon="fas fa-car-crash" 
                    label="Accidental Reports" 
                    :active="request()->routeIs('admin.accidental_reports.*') || request()->routeIs('admin.accidental-reports-fillable.*')">

                    <x-sidebar.link 
                        route="admin.accidental_reports.index" 
                        label="Accident Reports" 
                        :active="request()->routeIs('admin.accidental_reports.*')" 
                    />
                    <x-sidebar.link 
                        route="admin.accidental-reports-fillable.index" 
                        label="Report Categories" 
                        :active="request()->routeIs('admin.accidental-reports-fillable.*')" 
                    />
                </x-sidebar.dropdown>

                {{-- Locations --}}
                <x-sidebar.dropdown 
                    icon="fas fa-map-marker-alt" 
                    label="Locations" 
                    :active="request()->routeIs('admin.states.*') || request()->routeIs('admin.districts.*') || request()->routeIs('admin.dhams.*')">

                    <x-sidebar.link 
                        route="admin.states.index" 
                        label="States" 
                        :active="request()->routeIs('admin.states.*')" 
                    />
                    <x-sidebar.link 
                        route="admin.districts.index" 
                        label="Districts" 
                        :active="request()->routeIs('admin.districts.*')" 
                    />
                    <x-sidebar.link 
                        route="admin.dhams.index" 
                        label="Dhams" 
                        :active="request()->routeIs('admin.dhams.*')" 
                    />
                </x-sidebar.dropdown>
<x-sidebar.link 
                    route="admin.daily_reports_dhams.index" 
                    label="Daily Reports (Dhams)" 
                    :active="request()->routeIs('admin.daily_reports_dhams.*')" 
                />
            </x-sidebar.dropdown>

            {{-- Assignments --}}
            <x-sidebar.dropdown icon="fas fa-tasks" label="Assignments" :active="request()->routeIs('admin.district-users.*')">
                <x-sidebar.link 
                    route="admin.district-users.index" 
                    label="District Wise User" 
                    icon="fas fa-tasks"
                    :active="request()->routeIs('admin.district-users.*')" 
                />
            </x-sidebar.dropdown>

            {{-- Daily Reports --}}
            <x-sidebar.dropdown 
                icon="fas fa-file-alt" 
                label="Daily Reports" 
                :active="request()->routeIs('admin.daily_reports.*') || request()->routeIs('admin.daily_reports_fillable.*') || request()->routeIs('admin.district-reports.*') || request()->routeIs('admin.reports.*')">

                <x-sidebar.link 
                    route="admin.daily_reports.index" 
                    label="Daily Reports" 
                    :active="request()->routeIs('admin.daily_reports.*')" 
                />
                <x-sidebar.link 
                    route="admin.daily_reports_fillable.index" 
                    label="Report Categories" 
                    :active="request()->routeIs('admin.daily_reports_fillable.*')" 
                />
                <x-sidebar.link 
                    route="admin.district-reports.index" 
                    label="District Reports" 
                    :active="request()->routeIs('admin.district-reports.*')" 
                />
                
                <x-sidebar.link 
                    route="admin.reports.index" 
                    label="File Uploads" 
                    :active="request()->routeIs('admin.reports.*')" 
                />
            </x-sidebar.dropdown>

            {{-- Media Files --}}
            <x-sidebar.link 
                route="admin.media-files.index" 
                label="Media Files" 
                icon="fas fa-photo-video" 
                :active="request()->routeIs('admin.media-files.*')" 
            />

            {{-- Pages --}}
            <x-sidebar.link 
                route="admin.pages.list" 
                label="Pages" 
                icon="fas fa-file-contract" 
                :active="request()->routeIs('admin.pages.*')" 
            />

            {{-- Settings --}}
            <x-sidebar.link 
                route="admin.settings.index" 
                label="Settings" 
                icon="fas fa-cog" 
                :active="request()->routeIs('admin.settings.*')" 
            />

            {{-- Navbar Items --}}
            <x-sidebar.link 
                route="admin.navbar-items.index" 
                label="Navbar Items" 
                icon="fas fa-bars" 
                :active="request()->routeIs('admin.navbar-items.*')" 
            />

            {{-- Clear Cache --}}
            <form method="POST" action="{{ route('admin.clear.cache') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
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
