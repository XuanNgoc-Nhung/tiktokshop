@php
use App\Helpers\LanguageHelper;
$__notes = [LanguageHelper::class, 'getNotesTranslation'];
$__home = [LanguageHelper::class, 'getHomeTranslation'];
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Multilingual Notes - {{ LanguageHelper::getCurrentLanguage()['name'] }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="fas fa-globe"></i> 
                    Demo Multilingual Notes - {{ LanguageHelper::getCurrentLanguage()['name'] }}
                </h1>
                
                <!-- Language Switcher -->
                <div class="mb-4">
                    <h5>Switch Language:</h5>
                    <div class="btn-group" role="group">
                        <a href="{{ route('language.switch', 'vi') }}" class="btn btn-outline-primary">🇻🇳 Tiếng Việt</a>
                        <a href="{{ route('language.switch', 'en') }}" class="btn btn-outline-primary">🇺🇸 English</a>
                        <a href="{{ route('language.switch', 'ja') }}" class="btn btn-outline-primary">🇯🇵 日本語</a>
                        <a href="{{ route('language.switch', 'zh') }}" class="btn btn-outline-primary">🇨🇳 中文</a>
                        <a href="{{ route('language.switch', 'bn') }}" class="btn btn-outline-primary">🇧🇩 বাংলা</a>
                    </div>
                </div>

                <!-- General Notes -->
                <h3 class="mt-5 mb-3">General Notes</h3>
                
                <x-multilingual-note type="info" key="ui_only_note" class="mb-3" />
                <x-multilingual-note type="info" key="no_data" class="mb-3" />
                <x-multilingual-note type="info" key="no_notifications" class="mb-3" />

                <!-- Transaction Notes -->
                <h3 class="mt-5 mb-3">Transaction Notes</h3>
                
                <x-multilingual-note type="info" key="transaction_processing" class="mb-3" />
                <x-multilingual-note type="success" key="transaction_success" class="mb-3" />
                <x-multilingual-note type="danger" key="transaction_failed" class="mb-3" />
                <x-multilingual-note type="warning" key="transaction_pending" class="mb-3" />

                <!-- System Notes -->
                <h3 class="mt-5 mb-3">System Notes</h3>
                
                <x-multilingual-note type="warning" key="system_maintenance" class="mb-3" />
                <x-multilingual-note type="info" key="feature_coming_soon" class="mb-3" />
                <x-multilingual-note type="info" key="beta_feature" class="mb-3" />

                <!-- Validation Notes -->
                <h3 class="mt-5 mb-3">Validation Notes</h3>
                
                <x-multilingual-note type="warning" key="required_field" class="mb-3" />
                <x-multilingual-note type="danger" key="invalid_format" class="mb-3" />
                <x-multilingual-note type="info" key="min_length" class="mb-3" />
                <x-multilingual-note type="info" key="max_length" class="mb-3" />

                <!-- Success Messages -->
                <h3 class="mt-5 mb-3">Success Messages</h3>
                
                <x-multilingual-note type="success" key="save_success" class="mb-3" />
                <x-multilingual-note type="success" key="update_success" class="mb-3" />
                <x-multilingual-note type="success" key="delete_success" class="mb-3" />

                <!-- Error Messages -->
                <h3 class="mt-5 mb-3">Error Messages</h3>
                
                <x-multilingual-note type="danger" key="save_failed" class="mb-3" />
                <x-multilingual-note type="danger" key="update_failed" class="mb-3" />
                <x-multilingual-note type="danger" key="delete_failed" class="mb-3" />
                <x-multilingual-note type="danger" key="network_error" class="mb-3" />
                <x-multilingual-note type="danger" key="server_error" class="mb-3" />

                <!-- Warning Messages -->
                <h3 class="mt-5 mb-3">Warning Messages</h3>
                
                <x-multilingual-note type="warning" key="confirm_action" class="mb-3" />
                <x-multilingual-note type="warning" key="action_cannot_undo" class="mb-3" />
                <x-multilingual-note type="warning" key="data_will_be_lost" class="mb-3" />

                <!-- Info Messages -->
                <h3 class="mt-5 mb-3">Info Messages</h3>
                
                <x-multilingual-note type="info" key="loading" class="mb-3" />
                <x-multilingual-note type="info" key="processing" class="mb-3" />
                <x-multilingual-note type="info" key="please_wait" class="mb-3" />
                <x-multilingual-note type="info" key="refresh_page" class="mb-3" />

                <!-- Direct Translation Examples -->
                <h3 class="mt-5 mb-3">Direct Translation Examples</h3>
                
                <div class="alert alert-info">
                    <strong>Direct Translation:</strong> {{ $__notes('ui_only_note') }}
                </div>
                
                <div class="alert alert-warning">
                    <strong>With Parameters:</strong> {{ $__notes('min_length', null, ['min' => 6]) }}
                </div>

                <!-- Home Translations -->
                <h3 class="mt-5 mb-3">Home Translations</h3>
                
                <div class="alert alert-info">
                    <strong>No Data:</strong> {{ $__home('no_data') }}
                </div>
                
                <div class="alert alert-info">
                    <strong>No Notifications:</strong> {{ $__home('no_notifications') }}
                </div>

                <!-- Current Language Info -->
                <div class="mt-5 p-3 bg-light rounded">
                    <h5>Current Language Information:</h5>
                    <p><strong>Language:</strong> {{ LanguageHelper::getCurrentLanguage()['name'] }}</p>
                    <p><strong>Flag:</strong> {{ LanguageHelper::getCurrentLanguage()['flag'] }}</p>
                    <p><strong>Code:</strong> {{ LanguageHelper::getCurrentLanguage()['code'] }}</p>
                    <p><strong>Locale:</strong> {{ app()->getLocale() }}</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
