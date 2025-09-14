<div class="language-selector">
    <button class="language-dropdown" onclick="toggleLanguageDropdown()">
        <span id="current-language" style="scale: 1.5;">
            {!! $availableLanguages[$currentLocale]['flag'] !!}
            {{-- {{ strtoupper($currentLocale) }} --}}
        </span>
        <i class="fas fa-chevron-down"></i>
    </button>
    <div class="language-options" id="language-options">
        @foreach($availableLanguages as $locale => $language)
            <div class="language-option {{ $currentLocale == $locale ? 'active' : '' }}" onclick="selectLanguage('{{ $locale }}', '{{ $language['code'] }}')">
                <div class="flag-icon">{!! $language['flag'] !!}</div>
                <span>{{ $language['name'] }}</span>
            </div>
        @endforeach
    </div>
</div>

<script>
function selectLanguage(langCode, langDisplay) {
    // Haptic feedback simulation
    if ('vibrate' in navigator) {
        navigator.vibrate(10);
    }
    
    // Redirect to language switch route
    window.location.href = `/language/${langCode}`;
}

function toggleLanguageDropdown() {
    // Haptic feedback simulation
    if ('vibrate' in navigator) {
        navigator.vibrate(10);
    }
    
    const dropdown = document.getElementById('language-options');
    const button = document.querySelector('.language-dropdown');
    
    if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        button.classList.remove('open');
    } else {
        dropdown.classList.add('show');
        button.classList.add('open');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const languageSelector = document.querySelector('.language-selector');
    if (!languageSelector.contains(event.target)) {
        document.getElementById('language-options').classList.remove('show');
        document.querySelector('.language-dropdown').classList.remove('open');
    }
});
</script>