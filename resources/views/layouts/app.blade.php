<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ allsettings('site.title') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- jQuery & DataTables (if needed) -->
        <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">

    <!-- JS -->
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
 
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/jszip.min.js') }}"></script>
    <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/tinymce.min.js') }}"></script>
</head>

<body x-data="themeLayout()" :class="{ 'dark': darkMode }" class="font-sans antialiased bg-gray-50 text-gray-800 dark:bg-gray-900 dark:text-gray-200 transition-colors duration-300">

    <div class="flex h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700 overflow-y-auto transform transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-lg">
            <div class="h-16 flex items-center justify-between px-4 border-b dark:border-gray-700">
                <a href="{{ route('dashboard') }}"
                    class="text-xl font-bold text-indigo-600 dark:text-indigo-400 flex items-center">
                    <i class="fas fa-cube mr-2"></i>
                    {{ allsettings('admin.title') }}
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 dark:text-gray-400">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <x-sidebar />
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm z-10 border-b dark:border-gray-700">
                <div class="flex justify-between items-center p-4 sm:px-6">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true"
                            class="lg:hidden mr-4 text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $header ?? 'Dashboard' }}</h1>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <div class="flex items-center space-x-4">
                        <button @click="toggleDarkMode()"
                            class="p-2 rounded-full bg-indigo-600 dark:bg-indigo-800 text-white hover:bg-indigo-700 dark:hover:bg-indigo-900 transition-colors">
                            <template x-if="!darkMode">
                                <i class="fas fa-moon"></i>
                            </template>
                            <template x-if="darkMode">
                                <i class="fas fa-sun"></i>
                            </template>
                        </button>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="hidden md:inline mr-2 text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                                    <img class="h-8 w-8 rounded-full object-cover border-2 border-white dark:border-gray-600" src="{{ Auth::user()->profile_photo_url }}" />
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('profile.show') }}"><i class="fas fa-user mr-2 text-gray-400"></i> Profile</x-dropdown-link>
                                <x-dropdown-link href="#"><i class="fas fa-cog mr-2 text-gray-400"></i> Settings</x-dropdown-link>
                                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit()" class="flex items-center text-red-600 dark:text-red-400">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <script src="{{ asset('js/alpine.min.js') }}" defer></script>
    <script>
        function themeLayout() {
            return {
                darkMode: localStorage.getItem('darkMode') === 'true',
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                }
            }
        }
    </script>
</body>
</html>
