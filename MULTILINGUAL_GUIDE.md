# Hướng dẫn sử dụng hệ thống đa ngôn ngữ

## Tổng quan

Hệ thống đã được cấu hình để hỗ trợ đa ngôn ngữ riêng biệt cho:
- **Admin Panel**: Sử dụng ngôn ngữ admin
- **User Interface**: Sử dụng ngôn ngữ user

## Cấu trúc thư mục

```
resources/lang/
├── admin/
│   ├── en/auth.php
│   ├── vi/auth.php
│   ├── ja/auth.php
│   ├── zh/auth.php
│   └── bn/auth.php
└── user/
    ├── en/auth.php
    ├── vi/auth.php
    ├── ja/auth.php
    ├── zh/auth.php
    └── bn/auth.php
```

## Các ngôn ngữ được hỗ trợ

- **Tiếng Việt (vi)**: Ngôn ngữ mặc định
- **English (en)**: Tiếng Anh
- **日本語 (ja)**: Tiếng Nhật
- **中文 (zh)**: Tiếng Trung
- **বাংলা (bn)**: Tiếng Bengali

## Cách sử dụng

### 1. Trong Controller

#### Sử dụng ngôn ngữ Admin
```php
use App\Helpers\LanguageHelper;

// Lấy translation cho admin
$message = LanguageHelper::getAdminTranslation('login_success');

// Lấy translation với tham số
$message = LanguageHelper::getAdminTranslation('welcome_message', null, ['name' => 'Admin']);
```

#### Sử dụng ngôn ngữ User
```php
use App\Helpers\LanguageHelper;

// Lấy translation cho user
$message = LanguageHelper::getUserTranslation('login_success');

// Lấy translation với tham số
$message = LanguageHelper::getUserTranslation('welcome_message', null, ['name' => 'User']);
```

### 2. Trong View

#### Sử dụng ngôn ngữ Admin
```blade
{{ \App\Helpers\LanguageHelper::getAdminTranslation('dashboard') }}
```

#### Sử dụng ngôn ngữ User
```blade
{{ \App\Helpers\LanguageHelper::getUserTranslation('home') }}
```

### 3. Chuyển đổi ngôn ngữ

#### Cho User
```blade
<a href="{{ route('language.switch', 'en') }}">English</a>
<a href="{{ route('language.switch', 'vi') }}">Tiếng Việt</a>
```

#### Cho Admin
```blade
<a href="{{ route('admin.language.switch', 'en') }}">English</a>
<a href="{{ route('admin.language.switch', 'vi') }}">Tiếng Việt</a>
```

### 4. Sử dụng Language Switcher Component

#### Cho User
```blade
<x-user.language-switcher />
```

#### Cho Admin
```blade
<x-admin.language-switcher />
```

## Middleware

Hệ thống sử dụng middleware `LanguageMiddleware` để tự động xử lý ngôn ngữ:

- `language.user`: Cho các route user
- `language.admin`: Cho các route admin

## Thêm ngôn ngữ mới

### 1. Thêm ngôn ngữ vào LanguageHelper

Cập nhật file `app/Helpers/LanguageHelper.php`:

```php
public static function getAvailableLanguages()
{
    return [
        'vi' => [
            'name' => 'Việt Nam',
            'flag' => '🇻🇳',
            'code' => 'VI'
        ],
        'en' => [
            'name' => 'English',
            'flag' => '🇺🇸',
            'code' => 'EN'
        ],
        // Thêm ngôn ngữ mới
        'fr' => [
            'name' => 'Français',
            'flag' => '🇫🇷',
            'code' => 'FR'
        ]
    ];
}
```

### 2. Tạo file ngôn ngữ

Tạo file `resources/lang/admin/fr/auth.php` và `resources/lang/user/fr/auth.php`:

```php
<?php

return [
    'login' => 'Connexion',
    'password' => 'Mot de passe',
    // ... các key khác
];
```

### 3. Cập nhật routes

Thêm ngôn ngữ mới vào route chuyển đổi:

```php
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi', 'ja', 'zh', 'bn', 'fr'])) {
        session(['language' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');
```

## Thêm key ngôn ngữ mới

### 1. Thêm vào file admin
Cập nhật `resources/lang/admin/{locale}/auth.php`:

```php
return [
    // ... các key hiện có
    'new_key' => 'New Value',
];
```

### 2. Thêm vào file user
Cập nhật `resources/lang/user/{locale}/auth.php`:

```php
return [
    // ... các key hiện có
    'new_key' => 'New Value',
];
```

### 3. Sử dụng trong code
```php
// Admin
$value = LanguageHelper::getAdminTranslation('new_key');

// User
$value = LanguageHelper::getUserTranslation('new_key');
```

## Lưu ý

1. **Fallback**: Nếu không tìm thấy translation, hệ thống sẽ tự động fallback sang ngôn ngữ khác hoặc key gốc
2. **Session**: Ngôn ngữ được lưu trong session với key `language`
3. **Middleware**: Mỗi route group sử dụng middleware riêng để xử lý ngôn ngữ phù hợp
4. **Components**: Sử dụng components có sẵn để hiển thị language switcher

## Troubleshooting

### Lỗi translation không hiển thị
1. Kiểm tra file ngôn ngữ có tồn tại không
2. Kiểm tra key có đúng không
3. Kiểm tra middleware có được áp dụng không

### Lỗi component không hiển thị
1. Kiểm tra component có tồn tại trong thư mục `resources/views/components/`
2. Kiểm tra namespace của component
3. Kiểm tra route chuyển đổi ngôn ngữ có hoạt động không
