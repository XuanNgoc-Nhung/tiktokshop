@php
use App\Helpers\LanguageHelper;
$__notes = [LanguageHelper::class, 'getAdminNotesTranslation'];
@endphp

@props([
    'type' => 'info', // info, warning, error, success
    'key' => '',
    'fallback' => '',
    'class' => '',
    'icon' => true
])

@php
    $noteText = $key ? $__notes($key) : $fallback;
    
    $typeClasses = [
        'info' => 'alert-info',
        'warning' => 'alert-warning', 
        'error' => 'alert-danger',
        'success' => 'alert-success'
    ];
    
    $typeIcons = [
        'info' => 'fas fa-info-circle',
        'warning' => 'fas fa-exclamation-triangle',
        'error' => 'fas fa-times-circle',
        'success' => 'fas fa-check-circle'
    ];
    
    $alertClass = $typeClasses[$type] ?? 'alert-info';
    $iconClass = $typeIcons[$type] ?? 'fas fa-info-circle';
@endphp

<div class="alert {{ $alertClass }} {{ $class }}" role="alert">
    @if($icon)
        <i class="{{ $iconClass }} me-2"></i>
    @endif
    {{ $noteText }}
</div>
