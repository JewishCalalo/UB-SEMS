<a href="{{ $href }}"
    {{ $attributes->merge(['class' => $getButtonClasses()]) }}
>
    {{-- @if ($icon) --}}
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $icon !!}
        </svg>
    {{-- @endif --}}

    {{ $label }}
</a>
