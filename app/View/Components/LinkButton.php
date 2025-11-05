<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LinkButton extends Component
{
    public string $href;
    public string $label;
    public string $color;
    public ?string $icon;

    public function __construct(string $href = '#', string $label = '', string $color = 'red', ?string $icon = null)
    {
        $this->href = $href;
        $this->label = $label;
        $this->color = $color;
        $this->icon = $icon; 
    }

    /**
     * Get the CSS classes for the button based on color
     */
    public function getButtonClasses(): string
    {
        $baseClasses = "inline-flex items-center px-4 py-2 text-sm font-medium rounded-md transition duration-200 text-white";
        
        return match($this->color) {
            'red' => $baseClasses . ' bg-red-600 hover:bg-red-700',
            'blue' => $baseClasses . ' bg-blue-600 hover:bg-blue-700',
            'green' => $baseClasses . ' bg-green-600 hover:bg-green-700',
            'yellow' => $baseClasses . ' bg-yellow-600 hover:bg-yellow-700',
            'purple' => $baseClasses . ' bg-purple-600 hover:bg-purple-700',
            'gray' => $baseClasses . ' bg-gray-600 hover:bg-gray-700',
            default => $baseClasses . ' bg-red-600 hover:bg-red-700',
        };
    }

    public function render(): View|Closure|string
    {
        return view('components.link-button');
    }
}