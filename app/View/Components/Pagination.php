<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Pagination extends Component
{
    public LengthAwarePaginator $paginator;
    public string $showInfo;
    public bool $showInfoText;

    /**
     * Create a new component instance.
     */
    public function __construct(LengthAwarePaginator $paginator, bool $showInfoText = true)
    {
        $this->paginator = $paginator;
        $this->showInfoText = $showInfoText;
        
        if ($showInfoText) {
            $this->showInfo = __('admin::cms.showing') . ' ' . $paginator->firstItem() . ' ' . 
                             __('admin::cms.to') . ' ' . $paginator->lastItem() . ' ' . 
                             __('admin::cms.of') . ' ' . $paginator->total() . ' ' . 
                             __('admin::cms.results');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.pagination');
    }
}
