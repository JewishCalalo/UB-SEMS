@props([
    'name' => 'images',
    'label' => 'Upload Images',
    'multiple' => false,
    'accept' => 'image/*',
    'maxSize' => '2MB',
    'description' => null,
    'required' => false
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <input type="file" 
           name="{{ $name }}{{ $multiple ? '[]' : '' }}" 
           id="{{ $name }}" 
           {{ $multiple ? 'multiple' : '' }}
           accept="{{ $accept }}"
           {{ $required ? 'required' : '' }}
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
           {{ $attributes }}>
    
    @if($description)
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
    @else
        <p class="mt-1 text-sm text-gray-500">
            @if($multiple)
                You can select multiple images. Maximum file size: {{ $maxSize }} each.
            @else
                Maximum file size: {{ $maxSize }}.
            @endif
        </p>
    @endif
    
    @error($name . '.*')
        <p class="mt-1 text-sm text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
