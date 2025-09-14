@php
    use App\Helpers\LanguageHelper;
    $currentLocale = app()->getLocale();
    $languages = LanguageHelper::getAvailableLanguages();
@endphp

<div class="language-switcher dropdown">
    <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        {!! $languages[$currentLocale]['flag'] ?? '🌐' !!}
        {{ $languages[$currentLocale]['name'] ?? 'Language' }}
    </button>
    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
        @foreach($languages as $locale => $language)
            <li>
                <a class="dropdown-item {{ $locale === $currentLocale ? 'active' : '' }}" 
                   href="{{ route('admin.language.switch', $locale) }}">
                    {!! $language['flag'] !!} {{ $language['name'] }}
                    @if($locale === $currentLocale)
                        <i class="fas fa-check ms-2"></i>
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>

<style>
.language-switcher .dropdown-toggle {
    border: 1px solid #dee2e6;
    background: white;
    color: #495057;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.language-switcher .dropdown-toggle:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
}

.language-switcher .dropdown-toggle:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.language-switcher .dropdown-item {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.language-switcher .dropdown-item:hover {
    background-color: #f8f9fa;
}

.language-switcher .dropdown-item.active {
    background-color: #e9ecef;
    color: #495057;
}
</style>
