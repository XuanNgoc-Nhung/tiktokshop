<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Helpers\LanguageHelper;

class LanguageSelector extends Component
{
    public $currentLocale;
    public $availableLanguages;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->currentLocale = app()->getLocale();
        $this->availableLanguages = LanguageHelper::getAvailableLanguages();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.language-selector');
    }
}
