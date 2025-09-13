# Hướng dẫn theo dõi Log Rút tiền

## Vị trí file log
File log được lưu tại: `storage/logs/laravel.log`

## Các bước theo dõi log

### 1. Xem log real-time
```bash
cd /Applications/XAMPP/xamppfiles/htdocs/tiktokshop
tail -f storage/logs/laravel.log
```

### 2. Tìm log rút tiền cụ thể
```bash
# Tìm tất cả log rút tiền
grep "RÚT TIỀN" storage/logs/laravel.log

# Tìm log của user cụ thể (thay USER_ID bằng ID thực tế)
grep "User ID: USER_ID" storage/logs/laravel.log

# Tìm log lỗi rút tiền
grep "LỖI KHI RÚT TIỀN" storage/logs/laravel.log
```

## Các loại log được ghi

### 1. Log bắt đầu xử lý
```
=== BẮT ĐẦU XỬ LÝ RÚT TIỀN ===
User ID: [USER_ID]
Request data: [DỮ LIỆU REQUEST]
Profile data - Số dư: [SỐ_DỰ], Hoa hồng: [HOA_HỒNG]
```

### 2. Log kiểm tra thông tin
- Kiểm tra thông tin ngân hàng
- Kiểm tra mật khẩu rút tiền
- Tính toán số tiền rút tối đa
- Validation dữ liệu

### 3. Log cập nhật số dư
```
Bắt đầu cập nhật số dư
Đã trừ từ hoa hồng
Đã trừ từ số dư
Đã cập nhật profile thành công
```

### 4. Log tạo bản ghi
- Tạo bản ghi rút tiền (nap_rut)
- Tạo lịch sử giao dịch (lich_su)

### 5. Log hoàn thành
```
=== HOÀN THÀNH RÚT TIỀN THÀNH CÔNG ===
```

### 6. Log lỗi
```
=== LỖI KHI RÚT TIỀN ===
[Chi tiết lỗi, file, dòng, stack trace]
```

## Cách debug

### 1. Kiểm tra log theo thời gian
```bash
# Xem log trong 1 giờ qua
grep "$(date '+%Y-%m-%d %H')" storage/logs/laravel.log | grep "RÚT TIỀN"
```

### 2. Kiểm tra log của user cụ thể
```bash
# Thay USER_ID bằng ID thực tế
grep "User ID: USER_ID" storage/logs/laravel.log -A 5 -B 5
```

### 3. Kiểm tra lỗi
```bash
grep "ERROR" storage/logs/laravel.log | grep "RÚT TIỀN"
```

## Các trường hợp cần chú ý

1. **User thiếu thông tin ngân hàng**: Log level WARNING
2. **Mật khẩu rút tiền không đúng**: Log level WARNING  
3. **Số dư không đủ**: Log level WARNING
4. **Validation failed**: Log level WARNING
5. **Lỗi hệ thống**: Log level ERROR

## Lưu ý bảo mật

- Log chứa thông tin nhạy cảm (mật khẩu, số tiền)
- Chỉ admin mới nên có quyền truy cập file log
- Xóa log cũ định kỳ để tránh lộ thông tin
