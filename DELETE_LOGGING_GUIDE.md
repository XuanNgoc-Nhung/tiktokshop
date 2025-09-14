# Hướng dẫn theo dõi Logging cho chức năng Xóa sản phẩm

## 📋 Tổng quan
Đã bổ sung logging chi tiết cho chức năng xóa sản phẩm để dễ dàng theo dõi và debug.

## 🔍 Các loại logging được thêm

### 1. **Client-side Logging (Browser Console)**
Mở Developer Tools (F12) → Console để xem:

#### Khi click nút xóa:
```
🗑️ [DELETE] Request to delete product: {productId: 123, productName: "Tên sản phẩm"}
```

#### Khi xác nhận xóa:
```
🚀 [DELETE] Starting deletion process for product ID: 123
📡 [DELETE] Sending POST request to: http://localhost/admin/xoa-san-pham-trang-chu/123
🔐 [DELETE] CSRF Token: Present
```

#### Khi nhận response:
```
✅ [DELETE] Response received: {success: true, message: "Xóa sản phẩm thành công!"}
🎉 [DELETE] Deletion successful
🔄 [DELETE] Reloading page...
```

**Lưu ý:** Trang sẽ được tải lại ngay lập tức sau khi xóa thành công để cập nhật danh sách sản phẩm.

#### Khi có lỗi:
```
❌ [DELETE] Request failed: Error: Network Error
❌ [DELETE] Error details: {message: "...", status: 500, ...}
```

### 2. **Server-side Logging (Laravel Log)**
Xem file: `storage/logs/laravel.log`

#### Khi bắt đầu xóa:
```
[2024-01-15 10:30:00] local.INFO: 🗑️ [DELETE] Starting deletion process {"product_id":123,"user_id":1,"ip":"127.0.0.1","user_agent":"Mozilla/5.0..."}
```

#### Khi tìm thấy sản phẩm:
```
[2024-01-15 10:30:00] local.INFO: 📦 [DELETE] Product found {"product_id":123,"product_name":"Tên sản phẩm","image_path":"products/image.jpg"}
```

#### Khi xóa hình ảnh:
```
[2024-01-15 10:30:00] local.INFO: 🖼️ [DELETE] Image deleted successfully {"path":"/path/to/public/products/image.jpg"}
```

#### Khi xóa thành công:
```
[2024-01-15 10:30:00] local.INFO: ✅ [DELETE] Product deleted successfully {"product_id":123,"product_name":"Tên sản phẩm"}
```

#### Khi có lỗi:
```
[2024-01-15 10:30:00] local.ERROR: ❌ [DELETE] Deletion failed {"product_id":123,"error":"Error message","trace":"..."}
```

## 🛠️ Cách theo dõi

### 1. **Theo dõi real-time trong browser:**
1. Mở Developer Tools (F12)
2. Chuyển đến tab Console
3. Thực hiện thao tác xóa
4. Xem các log messages với emoji và prefix [DELETE]

### 2. **Theo dõi server logs:**
```bash
# Xem log real-time
tail -f storage/logs/laravel.log

# Hoặc filter chỉ log xóa
tail -f storage/logs/laravel.log | grep "DELETE"

# Xem log của ngày hôm nay
grep "$(date '+%Y-%m-%d')" storage/logs/laravel.log | grep "DELETE"
```

### 3. **Tìm kiếm log cụ thể:**
```bash
# Tìm log của sản phẩm ID 123
grep "product_id.*123" storage/logs/laravel.log

# Tìm log lỗi
grep "❌.*DELETE" storage/logs/laravel.log

# Tìm log thành công
grep "✅.*DELETE" storage/logs/laravel.log
```

## 🐛 Debug các vấn đề thường gặp

### 1. **Lỗi CSRF Token:**
- Kiểm tra console: `🔐 [DELETE] CSRF Token: Missing`
- Kiểm tra meta tag trong HTML: `<meta name="csrf-token" content="...">`

### 2. **Lỗi 404 Not Found:**
- Kiểm tra console: `❌ [DELETE] Error details: {status: 404}`
- Kiểm tra route: `php artisan route:list | grep xoa-san-pham-trang-chu`

### 3. **Lỗi 500 Internal Server Error:**
- Kiểm tra server log: `❌ [DELETE] Deletion failed`
- Xem chi tiết error message và stack trace

### 4. **Không xóa được hình ảnh:**
- Kiểm tra server log: `⚠️ [DELETE] Failed to delete image`
- Kiểm tra quyền ghi file trong thư mục `public/products/`

## 📊 Thông tin được log

### Client-side:
- Product ID và tên sản phẩm
- URL request
- CSRF token status
- Response data
- Error details

### Server-side:
- Product ID và tên sản phẩm
- User ID thực hiện xóa
- IP address
- User agent
- Image path và kết quả xóa file
- Error messages và stack trace

## 🔧 Cấu hình logging

Logging được cấu hình trong `config/logging.php`. Mặc định sẽ ghi vào:
- File: `storage/logs/laravel.log`
- Level: `info` và `error`

Để thay đổi level logging, sửa trong `.env`:
```
LOG_LEVEL=debug
```
