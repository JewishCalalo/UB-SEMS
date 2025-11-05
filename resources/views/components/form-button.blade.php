@props([
    'type' => 'submit',
    'variant' => 'primary', // primary, secondary, danger, success
    'size' => 'md', // sm, md, lg
    'disabled' => false,
    'icon' => null,
    'href' => null
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2';
    
    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3 text-sm',
        'lg' => 'px-8 py-4 text-base'
    ];
    
    $variantClasses = [
        'primary' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'secondary' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
        'danger' => 'bg-red-700 text-white hover:bg-red-800 focus:ring-red-500',
        'success' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500'
    ];
    
    $classes = $baseClasses . ' ' . $sizeClasses[$size] . ' ' . $variantClasses[$variant];
    
    if ($disabled) {
        $classes .= ' opacity-50 cursor-not-allowed';
    }
@endphp

@if($href)
    <a href="{{ $href }}" 
       class="{{ $classes }}"
       {{ $attributes }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" 
            {{ $disabled ? 'disabled' : '' }}
            class="{{ $classes }}"
            {{ $attributes }}>
        @if($icon)
            <i class="{{ $icon }} mr-2"></i>
        @endif
        {{ $slot }}
    </button>
@endif
