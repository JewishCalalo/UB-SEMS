@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-4 pe-4 py-2 rounded-full text-start text-base font-semibold text-white bg-red-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-150 ease-in-out'
            : 'block w-full ps-4 pe-4 py-2 rounded-full text-start text-base font-medium text-gray-800 hover:text-red-700 hover:bg-red-50 hover:ring-1 hover:ring-red-200 focus:outline-none focus:bg-red-50 focus:text-red-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} {{ ($active ?? false) ? 'aria-current=page' : '' }}>
    {{ $slot }}
</a>
