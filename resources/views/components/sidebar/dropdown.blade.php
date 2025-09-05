@props([
    'icon' => null,       // optional fontawesome icon
    'label',              // dropdown label
    'active' => false,    // boolean to set open/active state
])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }">
    <button @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-md transition-colors
            text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
        <span class="flex items-center">
            @if ($icon)
                <i class="{{ $icon }} mr-3"></i>
            @endif
            {{ $label }}
        </span>
        <i :class="open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
    </button>

    <div x-show="open" x-collapse class="ml-6 mt-1 space-y-1">
        {{ $slot }}
    </div>
</div>
