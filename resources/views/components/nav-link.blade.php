@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-full bg-red-600 text-white text-sm font-semibold leading-5 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-full text-sm font-medium leading-5 text-gray-700 hover:text-red-700 hover:bg-red-50 hover:ring-1 hover:ring-red-200 focus:outline-none focus:bg-red-50 focus:text-red-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} {{ ($active ?? false) ? 'aria-current=page' : '' }}>
    {{ $slot }}
</a>
