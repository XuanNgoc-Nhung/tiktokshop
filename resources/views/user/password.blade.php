@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
@endphp

@extends('user.layouts.app')

@section('title', ($__account('password') ?? 'Mật khẩu') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('password') ?? 'Mật khẩu' }}</div>
    <x-user.language-switcher />
    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '{{ route('account') }}';
            }
        }
    </script>
    <style>
        .password-card { 
            background: #ffffff; 
            border: 1px solid #e5e7eb; 
            border-radius: 12px; 
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); 
            margin-bottom: 20px;
        }
        .password-section {
            padding: 20px;
            border-bottom: 1px solid #f3f4f6;
        }
        .password-section:last-child {
            border-bottom: none;
        }
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }
        .section-title::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
        }
        .section-title i {
            color: #f4d03f;
            font-size: 22px;
            text-shadow: 0 2px 4px rgba(244, 208, 63, 0.3);
        }
        .section-desc {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 20px;
        }
        .form-label { 
            font-weight: 600; 
            color: #111827; 
            margin-bottom: 8px;
            display: block;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.2s ease;
            background: #ffffff;
            color: #000000;
            margin-bottom: 16px;
        }
        .form-input:focus {
            outline: none;
            border-color: #f4d03f;
            box-shadow: 0 0 0 3px rgba(244, 208, 63, 0.1);
        }
        .password-field {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s ease;
            z-index: 10;
        }
        .password-toggle:hover {
            color: #f4d03f;
        }
        .save-btn { 
            background: #f4d03f; 
            color: #8b4513; 
            border-radius: 10px; 
            padding: 12px 16px; 
            border: none; 
            width: 100%; 
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .save-btn:hover {
            background: #f1c40f;
            transform: translateY(-1px);
        }
        .save-btn:disabled {
            background: #d1d5db;
            color: #9ca3af;
            cursor: not-allowed;
            transform: none;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 16px;
            margin-left: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }
        .status-badge.set {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #16a34a;
            border: 2px solid #22c55e;
        }
        .status-badge.not-set {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #f59e0b;
            border: 2px solid #fbbf24;
        }
        .status-badge:hover {
            transform: scale(1.1);
        }
        .helper-text {
            font-size: 12px;
            color: #6b7280;
            margin-top: -8px;
            margin-bottom: 16px;
        }
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 20px 0;
        }
    </style>
</div>

<div class="container">
    <!-- Login Password Section -->
    <div class="password-card">
        <div class="password-section">
            <div class="section-title">
                <i class="fas fa-lock"></i>
                {{ $__account('change_login_password') ?? 'Đổi mật khẩu đăng nhập' }}
            </div>
            
            <form id="loginPasswordForm">
                <div class="password-field">
                    <label class="form-label">{{ $__account('current_password') ?? 'Mật khẩu hiện tại' }}</label>
                    <input type="password" id="current_login_password" class="form-input" placeholder="{{ $__account('current_password') ?? 'Mật khẩu hiện tại' }}" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('current_login_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <div class="password-field">
                    <label class="form-label">{{ $__account('new_password') ?? 'Mật khẩu mới' }}</label>
                    <input type="password" id="new_login_password" class="form-input" placeholder="{{ $__account('new_password') ?? 'Mật khẩu mới' }}" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('new_login_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <div class="password-field">
                    <label class="form-label">{{ $__account('confirm_password') ?? 'Xác nhận mật khẩu' }}</label>
                    <input type="password" id="confirm_login_password" class="form-input" placeholder="{{ $__account('confirm_password') ?? 'Xác nhận mật khẩu' }}" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_login_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <button type="submit" class="save-btn" id="btnChangeLoginPassword">
                    <i class="fas fa-save me-2"></i>{{ $__account('change_login_password') ?? 'Đổi mật khẩu đăng nhập' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Transfer Password Section -->
    <div class="password-card">
        <div class="password-section">
            <div class="section-title">
                <i class="fas fa-money-bill-transfer"></i>
                {{ $__account('change_transfer_password') ?? 'Đổi mật khẩu chuyển tiền' }}
                @if($user->mat_khau_chuyen_tien)
                    <span class="status-badge set">
                        <i class="fas fa-check-circle"></i>
                    </span>
                @else
                    <span class="status-badge not-set">
                        <i class="fas fa-times-circle"></i>
                    </span>
                @endif
            </div>
            
            <form id="transferPasswordForm">
                <div class="password-field">
                    <label class="form-label">{{ $__account('current_login_password') ?? 'Mật khẩu đăng nhập hiện tại' }}</label>
                    <input type="password" id="current_login_password_for_transfer" class="form-input" placeholder="{{ $__account('current_login_password') ?? 'Mật khẩu đăng nhập hiện tại' }}" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('current_login_password_for_transfer')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <div class="password-field">
                    <label class="form-label">
                        {{ $user->mat_khau_chuyen_tien ? ($__account('new_password') ?? 'Mật khẩu mới') : ($__account('set_transfer_password') ?? 'Đặt mật khẩu chuyển tiền') }}
                    </label>
                    <input type="password" id="new_transfer_password" class="form-input" placeholder="{{ $user->mat_khau_chuyen_tien ? ($__account('new_password') ?? 'Mật khẩu mới') : ($__account('set_transfer_password') ?? 'Đặt mật khẩu chuyển tiền') }}" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('new_transfer_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <div class="password-field">
                    <label class="form-label">{{ $__account('confirm_password') ?? 'Xác nhận mật khẩu' }}</label>
                    <input type="password" id="confirm_transfer_password" class="form-input" placeholder="{{ $__account('confirm_password') ?? 'Xác nhận mật khẩu' }}" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('confirm_transfer_password')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                
                <button type="submit" class="save-btn" id="btnChangeTransferPassword">
                    <i class="fas fa-save me-2"></i>
                    {{ $user->mat_khau_chuyen_tien ? ($__account('change_transfer_password') ?? 'Đổi mật khẩu chuyển tiền') : ($__account('set_transfer_password') ?? 'Đặt mật khẩu chuyển tiền') }}
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const toggle = input.nextElementSibling;
        const icon = toggle.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Login Password Form
    document.getElementById('loginPasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const currentPassword = document.getElementById('current_login_password').value;
        const newPassword = document.getElementById('new_login_password').value;
        const confirmPassword = document.getElementById('confirm_login_password').value;
        const btn = document.getElementById('btnChangeLoginPassword');
        
        // Validation
        if (!currentPassword || !newPassword || !confirmPassword) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}');
            return;
        }
        
        if (newPassword.length < 6) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('password_requirements') ?? 'Mật khẩu phải có ít nhất 6 ký tự' }}');
            return;
        }
        
        if (newPassword !== confirmPassword) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('password_mismatch') ?? 'Mật khẩu xác nhận không khớp' }}');
            return;
        }
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
        
        try {
            const response = await axios.post('{{ route('account.password.change-login') }}', {
                current_password: currentPassword,
                new_password: newPassword,
                confirm_password: confirmPassword,
                _token: '{{ csrf_token() }}'
            });
            
            if (response.data.success) {
                showToast('success', '{{ $__account('success_title') ?? 'Thành công' }}', response.data.message || '{{ $__account('password_changed_success') ?? 'Đổi mật khẩu thành công' }}');
                document.getElementById('loginPasswordForm').reset();
            } else {
                showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', response.data.message || '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}');
            }
        } catch (error) {
            let message = '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}';
            if (error.response && error.response.data) {
                message = error.response.data.message || (error.response.data.errors && Object.values(error.response.data.errors)[0][0]) || message;
            }
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', message);
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-save me-2"></i>{{ $__account('change_login_password') ?? 'Đổi mật khẩu đăng nhập' }}';
        }
    });

    // Transfer Password Form
    document.getElementById('transferPasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const currentLoginPassword = document.getElementById('current_login_password_for_transfer').value;
        const newPassword = document.getElementById('new_transfer_password').value;
        const confirmPassword = document.getElementById('confirm_transfer_password').value;
        const btn = document.getElementById('btnChangeTransferPassword');
        
        // Validation
        if (!currentLoginPassword) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}');
            return;
        }
        
        if (!newPassword || !confirmPassword) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}');
            return;
        }
        
        if (newPassword.length < 4) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('transfer_password_requirements') ?? 'Mật khẩu chuyển tiền phải có ít nhất 4 ký tự' }}');
            return;
        }
        
        if (newPassword !== confirmPassword) {
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', '{{ $__account('password_mismatch') ?? 'Mật khẩu xác nhận không khớp' }}');
            return;
        }
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
        
        try {
            const response = await axios.post('{{ route('account.password.change-transfer') }}', {
                current_login_password: currentLoginPassword,
                new_password: newPassword,
                confirm_password: confirmPassword,
                _token: '{{ csrf_token() }}'
            });
            
            if (response.data.success) {
                const hasCurrentPassword = {{ $user->mat_khau_chuyen_tien ? 'true' : 'false' }};
                const successMessage = hasCurrentPassword ? 
                    '{{ $__account('transfer_password_changed_success') ?? 'Đổi mật khẩu chuyển tiền thành công' }}' : 
                    '{{ $__account('transfer_password_set_success') ?? 'Đặt mật khẩu chuyển tiền thành công' }}';
                showToast('success', '{{ $__account('success_title') ?? 'Thành công' }}', response.data.message || successMessage);
                document.getElementById('transferPasswordForm').reset();
                // Reload page to update status badge
                setTimeout(() => window.location.reload(), 2000);
            } else {
                showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', response.data.message || '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}');
            }
        } catch (error) {
            let message = '{{ $__account('please_fill_all') ?? 'Vui lòng điền đầy đủ thông tin.' }}';
            if (error.response && error.response.data) {
                message = error.response.data.message || (error.response.data.errors && Object.values(error.response.data.errors)[0][0]) || message;
            }
            showToast('error', '{{ $__account('error_title') ?? 'Lỗi' }}', message);
        } finally {
            btn.disabled = false;
            const hasCurrentPassword = {{ $user->mat_khau_chuyen_tien ? 'true' : 'false' }};
            btn.innerHTML = hasCurrentPassword ? 
                '<i class="fas fa-save me-2"></i>{{ $__account('change_transfer_password') ?? 'Đổi mật khẩu chuyển tiền' }}' :
                '<i class="fas fa-save me-2"></i>{{ $__account('set_transfer_password') ?? 'Đặt mật khẩu chuyển tiền' }}';
        }
    });
</script>

@endsection
