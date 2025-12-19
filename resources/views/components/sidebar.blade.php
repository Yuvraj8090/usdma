<div
    class="flex flex-col h-full w-60 px-4 py-6 justify-between bg-white dark:bg-gray-800 transition-colors duration-300">

    <!-- ================== Navigation Header ================== -->
    <div>
        <p class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-3 ml-2">
            Navigation
        </p>

        <!-- ✅ Flash Messages -->
        @if (session('success'))
            <div
                class="mb-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-800 dark:border-green-600 dark:text-green-100 rounded-md flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="mb-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 dark:bg-red-800 dark:border-red-600 dark:text-red-100 rounded-md flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <!-- ================== Sidebar Navigation ================== -->
        <nav class="space-y-2">

            {{-- 🏠 Dashboard --}}
            <x-sidebar.link route="dashboard" label="Dashboard" icon="fas fa-home" :active="request()->routeIs('dashboard')" />
<x-sidebar.link route="admin.incidents.index" label="Add Incidents" icon="fas fa-bolt"
                        :active="request()->routeIs('admin.incidents.*')" />
            {{-- 👑 Admin Section --}}
            <x-sidebar.link route="admin.dhams.index" label="Dhams" icon="fas fa-place-of-worship"
                        :active="request()->routeIs('admin.dhams.*')" />
            <x-sidebar.dropdown icon="fas fa-user-shield" label="Admin" :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.daily_reports_fillable.*') || request()->routeIs('admin.accidental-reports-fillable.*') ||
                    request()->routeIs('admin.accidental_reports.*')">

                {{-- 👥 User Management --}}
                <x-sidebar.dropdown icon="fas fa-users-cog" label="User Management" :active="request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*')">
                    <x-sidebar.link route="admin.users.index" label="Users" icon="fas fa-user" :active="request()->routeIs('admin.users.*')" />
                    <x-sidebar.link route="admin.roles.index" label="Roles" icon="fas fa-user-tag" :active="request()->routeIs('admin.roles.*')" />
                </x-sidebar.dropdown>

                {{-- 📄 Daily Reports Fillable --}}
                <x-sidebar.dropdown icon="fas fa-file-alt" label="Daily Reports Management" :active="request()->routeIs('admin.daily_reports_fillable.*')">
                    <x-sidebar.link route="admin.daily_reports_fillable.index" label="Report Headers"
                        icon="fas fa-list-alt" :active="request()->routeIs('admin.daily_reports_fillable.*')" />
                </x-sidebar.dropdown>

                {{-- 🚗 Accidental Reports Fillable --}}
                <x-sidebar.dropdown icon="fas fa-car-crash" label="Accidental Reports" :active="request()->routeIs('admin.accidental-reports-fillable.*') ||
                    request()->routeIs('admin.accidental_reports.*')">
                    <x-sidebar.link route="admin.accidental-reports-fillable.index" label="Fillable Headers"
                        icon="fas fa-list-alt" :active="request()->routeIs('admin.accidental-reports-fillable.*')" />
                    <x-sidebar.link route="admin.accidental_reports.index" label="Accidental Reports"
                        icon="fas fa-exclamation-circle" :active="request()->routeIs('admin.accidental_reports.*')" />
                </x-sidebar.dropdown>

                {{-- 🌋 Natural Disaster Reports Fillable --}}
                <x-sidebar.dropdown icon="fas fa-mountain" label="Natural Disaster Reports" :active="request()->routeIs('admin.natural-disaster-fillable.*')">
                    <x-sidebar.link route="admin.natural-disaster-fillable.index" label="Disaster Headers"
                        icon="fas fa-list-alt" :active="request()->routeIs('admin.natural-disaster-fillable.*')" />
                </x-sidebar.dropdown>

                {{-- 🚧 Road Closed Management --}}
                <x-sidebar.dropdown icon="fas fa-road" label="Road Closed Management" :active="request()->routeIs('admin.road-closed-fillable.*') ||
                    request()->routeIs('admin.road-closed-reports.*')">
                    <x-sidebar.link route="admin.road-closed-fillable.index" label="Report Headers" icon="fas fa-list"
                        :active="request()->routeIs('admin.road-closed-fillable.*')" />
                    <x-sidebar.link route="admin.road-closed-reports.index" label="Reports" icon="fas fa-file-alt"
                        :active="request()->routeIs('admin.road-closed-reports.*')" />
                </x-sidebar.dropdown>

                {{-- 🗺️ Masters --}}
                <x-sidebar.dropdown icon="fas fa-map-marker-alt" label="Masters" :active="request()->routeIs('admin.states.*') ||
                    request()->routeIs('admin.districts.*') ||
                    request()->routeIs('admin.dhams.*') ||
                    request()->routeIs('admin.villages.*') ||
                    request()->routeIs('admin.tourist-visitor-details.*') ||
                    request()->routeIs('admin.incident-types.*') ||
                    request()->routeIs('admin.disaster-types.*') ||
                    request()->routeIs('admin.seasons.*')">


                    <x-sidebar.link route="admin.states.index" label="States" icon="fas fa-flag" :active="request()->routeIs('admin.states.*')" />
                    <x-sidebar.link route="admin.districts.index" label="Districts" icon="fas fa-city"
                        :active="request()->routeIs('admin.districts.*')" />
                    
                    <x-sidebar.link route="admin.tehsils.index" label="Tehsils" icon="fas fa-map" :active="request()->routeIs('admin.tehsils.*')" />
                    <x-sidebar.link route="admin.villages.index" label="Villages" icon="fas fa-home"
                        :active="request()->routeIs('admin.villages.*')" />
                    
                    <x-sidebar.link route="admin.tourist-visitor-details.index" label="Tourist Visitors"
                        icon="fas fa-users" :active="request()->routeIs('admin.tourist-visitor-details.*')" />
                    <x-sidebar.link route="admin.seasons.index" label="Seasons" icon="fas fa-cloud-sun"
                        :active="request()->routeIs('admin.seasons.*')" />

                    {{-- Already Existing --}}
                    <x-sidebar.link route="admin.incident-types.index" label="Incident-Types" icon="fas fa-flag"
                        :active="request()->routeIs('admin.incident-types.*')" />
                    <x-sidebar.link route="admin.disaster-types.index" label="Disaster-Types" icon="fas fa-flag"
                        :active="request()->routeIs('admin.disaster-types.*')" />
                </x-sidebar.dropdown>

                {{-- 📅 Meetings --}}
                <x-sidebar.link route="admin.meetings.index" label="Meetings" icon="fas fa-calendar-alt"
                    :active="request()->routeIs('admin.meetings.*')" />
            </x-sidebar.dropdown>

            {{-- 🧾 Assignments --}}
            <x-sidebar.dropdown icon="fas fa-tasks" label="Assignments" :active="request()->routeIs('admin.district-users.*')">
                <x-sidebar.link route="admin.district-users.index" label="District Wise User" icon="fas fa-user-friends"
                    :active="request()->routeIs('admin.district-users.*')" />
            </x-sidebar.dropdown>

            {{-- ⚙️ Resource Management --}}
            <x-sidebar.dropdown icon="fas fa-boxes" label="Resource Management" :active="request()->routeIs('admin.equipment.*') ||
                request()->routeIs('admin.equipment_categories.*') ||
                request()->routeIs('admin.manpower.*') ||
                request()->routeIs('admin.relief_material.*') ||
                request()->routeIs('admin.deployments.*')">

                <x-sidebar.link route="admin.equipment.index" label="Equipment" icon="fas fa-cogs" :active="request()->routeIs('admin.equipment.*')" />
                <x-sidebar.link route="admin.equipment_categories.index" label="Equipment Categories"
                    icon="fas fa-layer-group" :active="request()->routeIs('admin.equipment_categories.*')" />
                <x-sidebar.link route="admin.manpower.index" label="Manpower" icon="fas fa-users" :active="request()->routeIs('admin.manpower.*')" />
                <x-sidebar.link route="admin.relief_material.index" label="Relief Materials" icon="fas fa-box-open"
                    :active="request()->routeIs('admin.relief_material.*')" />
                <x-sidebar.link route="admin.deployments.index" label="Deployments" icon="fas fa-truck"
                    :active="request()->routeIs('admin.deployments.*')" />
            </x-sidebar.dropdown>

            {{-- 📊 Daily Reports --}}
            <x-sidebar.dropdown icon="fas fa-file-alt" label="Daily Reports" :active="request()->routeIs('admin.daily_reports.*') ||
                request()->routeIs('admin.district-reports.*') ||
                request()->routeIs('admin.daily_reports_dhams.*') ||
                request()->routeIs('admin.reports.*') ||
                request()->routeIs('admin.natural-disaster-reports.*')">

                <x-sidebar.link route="admin.daily_reports.index" label="Daily Reports" icon="fas fa-calendar-day"
                    :active="request()->routeIs('admin.daily_reports.*')" />

                <x-sidebar.link route="admin.district-reports.index" label="District Reports"
                    icon="fas fa-map-marked-alt" :active="request()->routeIs('admin.district-reports.*')" />

                <x-sidebar.link route="admin.daily_reports_dhams.index" label="Daily Reports (Dhams)"
                    icon="fas fa-hands-helping" :active="request()->routeIs('admin.daily_reports_dhams.*')" />

                <x-sidebar.link route="admin.reports.index" label="File Uploads" icon="fas fa-upload"
                    :active="request()->routeIs('admin.reports.*')" />

                <x-sidebar.link route="admin.natural-disaster-reports.index" label="Disaster Reports"
                    icon="fas fa-exclamation-triangle" :active="request()->routeIs('admin.natural-disaster-reports.*')" />
            </x-sidebar.dropdown>

            {{-- 🗂️ Miscellaneous --}}
            <x-sidebar.link route="admin.media-files.index" label="Media Files" icon="fas fa-photo-video"
                :active="request()->routeIs('admin.media-files.*')" />
            <x-sidebar.link route="admin.pages.list" label="Pages" icon="fas fa-file-contract" :active="request()->routeIs('admin.pages.*')" />
            <x-sidebar.link route="admin.navbar-items.index" label="Navbar Items" icon="fas fa-bars"
                :active="request()->routeIs('admin.navbar-items.*')" />
            <x-sidebar.link route="admin.settings.index" label="Settings" icon="fas fa-cog" :active="request()->routeIs('admin.settings.*')" />

            {{-- 🧹 Clear Cache --}}
            <form method="POST" action="{{ route('admin.clear.cache') }}" class="mt-3">
                @csrf
                <button type="submit"
                    class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white">
                    <i class="fas fa-broom mr-3"></i> Clear Cache
                </button>
            </form>

        </nav>

    </div>

    <!-- ================== User Info Section ================== -->
    <div class="mt-6">
        <div class="flex items-center p-3 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-800 rounded-md">
            <img class="h-9 w-9 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}" />
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Administrator</p>
            </div>
        </div>
    </div>
</div>
