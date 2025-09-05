@props([
    'route',   // named route
    'label',   // link text
    'active' => false, // boolean if link is active
    'icon' => null, // optional icon class
])

<a href="{{ route($route) }}"
   class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
   {{ $active
        ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'
        : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
    
    @if ($icon)
        <i class="{{ $icon }} mr-3"></i>
    @endif
    {{ $label }}
</a>
