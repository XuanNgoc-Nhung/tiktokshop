# Hướng dẫn sử dụng ghi chú đa ngôn ngữ

## Tổng quan

Hệ thống đã được cập nhật để hỗ trợ ghi chú đa ngôn ngữ một cách dễ dàng và nhất quán. Tất cả các ghi chú, thông báo và tin nhắn trong hệ thống giờ đây có thể được hiển thị theo ngôn ngữ người dùng đã chọn.

## Cấu trúc file ngôn ngữ

### File notes.php
Các file ngôn ngữ mới đã được tạo để quản lý ghi chú:
- `resources/lang/user/vi/notes.php` - Tiếng Việt
- `resources/lang/user/en/notes.php` - English  
- `resources/lang/user/ja/notes.php` - 日本語
- `resources/lang/user/zh/notes.php` - 中文
- `resources/lang/user/bn/notes.php` - বাংলা
- `resources/lang/admin/vi/notes.php` - Admin Tiếng Việt
- `resources/lang/admin/en/notes.php` - Admin English

## Cách sử dụng

### 1. Sử dụng trong Controller

```php
use App\Helpers\LanguageHelper;

// Lấy ghi chú cho user
$note = LanguageHelper::getNotesTranslation('ui_only_note');

// Lấy ghi chú cho admin
$note = LanguageHelper::getAdminNotesTranslation('ui_only_note');

// Lấy ghi chú với tham số
$note = LanguageHelper::getNotesTranslation('min_length', null, ['min' => 6]);
```

### 2. Sử dụng trong View

#### Cách 1: Sử dụng helper function
```blade
@php
use App\Helpers\LanguageHelper;
$__notes = [LanguageHelper::class, 'getNotesTranslation'];
@endphp

<div class="alert alert-info">
    {{ $__notes('ui_only_note') }}
</div>
```

#### Cách 2: Sử dụng component (Khuyến nghị)
```blade
<!-- Cho user -->
<x-multilingual-note 
    type="info" 
    key="ui_only_note" 
    class="mb-3" 
/>

<!-- Cho admin -->
<x-admin.multilingual-note 
    type="warning" 
    key="system_maintenance" 
    class="mb-3" 
/>
```

### 3. Các loại ghi chú có sẵn

#### Ghi chú chung
- `ui_only_note` - Ghi chú giao diện chỉ hiển thị
- `ui_only_note_short` - Ghi chú ngắn gọn
- `no_data` - Không có dữ liệu
- `no_notifications` - Chưa có thông báo
- `no_notifications_desc` - Mô tả không có thông báo

#### Ghi chú giao dịch
- `transaction_processing` - Giao dịch đang xử lý
- `transaction_success` - Giao dịch thành công
- `transaction_failed` - Giao dịch thất bại
- `transaction_pending` - Giao dịch chờ xử lý

#### Ghi chú hệ thống
- `system_maintenance` - Hệ thống bảo trì
- `feature_coming_soon` - Tính năng sắp ra mắt
- `beta_feature` - Tính năng thử nghiệm

#### Ghi chú validation
- `required_field` - Trường bắt buộc
- `invalid_format` - Định dạng không hợp lệ
- `min_length` - Độ dài tối thiểu
- `max_length` - Độ dài tối đa

#### Thông báo thành công
- `save_success` - Lưu thành công
- `update_success` - Cập nhật thành công
- `delete_success` - Xóa thành công

#### Thông báo lỗi
- `save_failed` - Lưu thất bại
- `update_failed` - Cập nhật thất bại
- `delete_failed` - Xóa thất bại
- `network_error` - Lỗi kết nối mạng
- `server_error` - Lỗi máy chủ

#### Thông báo cảnh báo
- `confirm_action` - Xác nhận hành động
- `action_cannot_undo` - Hành động không thể hoàn tác
- `data_will_be_lost` - Dữ liệu sẽ bị mất

#### Thông báo thông tin
- `loading` - Đang tải
- `processing` - Đang xử lý
- `please_wait` - Vui lòng chờ
- `refresh_page` - Làm mới trang

## Ví dụ sử dụng trong các trang

### Trang thông báo
```blade
@if ($notifications->isEmpty())
    <div class="text-center text-muted py-5">
        <i class="fas fa-bell-slash" style="font-size:48px;color:#d1d1d6"></i>
        <div class="mt-3">{{ $__home('no_notifications') }}</div>
    </div>
@endif
```

### Trang lịch sử
```blade
@forelse($items as $item)
    <!-- Nội dung item -->
@empty
    <tr>
        <td colspan="5" class="text-center text-muted py-4">
            {{ $__home('no_data') }}
        </td>
    </tr>
@endforelse
```

### Form validation
```blade
<x-multilingual-note 
    type="warning" 
    key="required_field" 
    class="mb-2" 
/>
```

### Thông báo hệ thống
```blade
<x-multilingual-note 
    type="info" 
    key="system_maintenance" 
    class="mb-3" 
/>
```

## Thêm ghi chú mới

### 1. Thêm vào file ngôn ngữ
Cập nhật tất cả file `notes.php` trong các thư mục ngôn ngữ:

```php
// resources/lang/user/vi/notes.php
return [
    // ... existing keys
    'new_note_key' => 'Nội dung ghi chú mới',
];
```

### 2. Sử dụng trong code
```blade
<x-multilingual-note 
    type="info" 
    key="new_note_key" 
/>
```

## Lưu ý quan trọng

1. **Fallback**: Hệ thống sẽ tự động fallback sang ngôn ngữ khác nếu không tìm thấy translation
2. **Consistency**: Sử dụng cùng một key cho cùng một loại ghi chú
3. **Type Safety**: Sử dụng component để đảm bảo type và styling nhất quán
4. **Performance**: Các translation được cache tự động bởi Laravel

## Troubleshooting

### Ghi chú không hiển thị đúng ngôn ngữ
1. Kiểm tra file ngôn ngữ có tồn tại không
2. Kiểm tra key có đúng không
3. Kiểm tra middleware ngôn ngữ có hoạt động không

### Component không hiển thị
1. Kiểm tra component có tồn tại trong thư mục `resources/views/components/`
2. Kiểm tra namespace của component
3. Kiểm tra syntax Blade

### Lỗi translation
1. Kiểm tra cú pháp PHP trong file ngôn ngữ
2. Kiểm tra cache translation: `php artisan config:clear`
3. Kiểm tra log Laravel để xem lỗi chi tiết
