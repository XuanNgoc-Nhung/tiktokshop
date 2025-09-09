@php
    use App\Helpers\LanguageHelper;
    $currentLocale = app()->getLocale();
    $languages = LanguageHelper::getAvailableLanguages();
@endphp

<div class="language-switcher dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-globe me-1"></i>
        {{ $languages[$currentLocale]['flag'] ?? '🌐' }}
        <span class="d-none d-sm-inline">{{ $languages[$currentLocale]['name'] ?? 'Language' }}</span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
        @foreach($languages as $locale => $language)
            <li>
                <a class="dropdown-item {{ $locale === $currentLocale ? 'active' : '' }}" 
                   href="{{ route('language.switch', $locale) }}">
                    <span class="me-2">{{ $language['flag'] }}</span>
                    {{ $language['name'] }}
                    @if($locale === $currentLocale)
                        <i class="fas fa-check ms-auto"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>

<style>
.language-switcher .dropdown-toggle {
    border: 1px solid #e0e0e0;
    background: white;
    color: #333;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    min-width: 60px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.language-switcher .dropdown-toggle:hover {
    background-color: #f8f9fa;
    border-color: #ccc;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.language-switcher .dropdown-toggle:focus {
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    border-color: #007bff;
}

.language-switcher .dropdown-menu {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    padding: 0.5rem 0;
    min-width: 150px;
}

.language-switcher .dropdown-item {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: all 0.2s ease;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.language-switcher .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #333;
}

.language-switcher .dropdown-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
    font-weight: 500;
}

.language-switcher .dropdown-item.active i {
    color: #1976d2;
}

/* Mobile responsive */
@media (max-width: 576px) {
    .language-switcher .dropdown-toggle {
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
        min-width: 50px;
        height: 36px;
    }
    
    .language-switcher .dropdown-menu {
        min-width: 140px;
    }
    
    .language-switcher .dropdown-item {
        padding: 0.6rem 0.8rem;
        font-size: 0.8rem;
    }
}
</style>
