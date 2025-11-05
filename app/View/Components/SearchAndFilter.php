<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchAndFilter extends Component
{
    /**
     * Create a new component instance.
     */

    public $categories;
    public $equipmentTypes;

    public function __construct($categories, $equipmentTypes)
    {
        $this->categories = $categories;
        $this->equipmentTypes = $equipmentTypes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-and-filter');
    }
}
