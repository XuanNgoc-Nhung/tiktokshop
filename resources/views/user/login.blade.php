@extends('user.layouts.app')

@section('title', 'Đăng nhập - TikTok Shop')

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">Đăng nhập</div>
    <div class="language-selector">
        <button class="language-dropdown" onclick="toggleLanguageDropdown()">
            <span id="current-language">VI</span>
            <i class="fas fa-chevron-down"></i>
        </button>
        <div class="language-options" id="language-options">
            <div class="language-option active" onclick="selectLanguage('vi', 'VI')">
                <div class="flag-icon" style="background: linear-gradient(45deg, #da251d, #ffcd00);"></div>
                <span>Tiếng Việt</span>
            </div>
            <div class="language-option" onclick="selectLanguage('en', 'EN')">
                <div class="flag-icon" style="background: linear-gradient(45deg, #012169, #ffffff, #c8102e);"></div>
                <span>English</span>
            </div>
            <div class="language-option" onclick="selectLanguage('zh', '中文')">
                <div class="flag-icon" style="background: linear-gradient(45deg, #de2910, #ffde00);"></div>
                <span>中文</span>
            </div>
            <div class="language-option" onclick="selectLanguage('ja', '日本語')">
                <div class="flag-icon" style="background: linear-gradient(45deg, #bc002d, #ffffff);"></div>
                <span>日本語</span>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            TikTok Shop
        </div>
        <div class="logo-subtitle">Mua sắm thông minh, tiết kiệm hơn</div>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login.authenticate') }}">
        @csrf
        
        @if($errors->has('login'))
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                {{ $errors->first('login') }}
            </div>
        @endif
        
        <!-- Phone Number Field -->
        <div class="form-group floating-label">
            <input 
                type="tel" 
                id="phone" 
                name="phone" 
                class="form-input" 
                placeholder=" "
                value="{{ old('phone') }}"
                required
            >
            <label class="form-label" for="phone">Số điện thoại</label>
            @error('phone')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password Field -->
        <div class="form-group floating-label">
            <div class="password-field">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder=" "
                    required
                >
                <label class="form-label" for="password">Mật khẩu</label>
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            @error('password')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Form Options -->
        <div class="form-options">
            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember" class="checkbox">
                <label for="remember" class="checkbox-label">Nhớ mật khẩu</label>
            </div>
            <a href="#" class="forgot-password">Quên mật khẩu?</a>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn-primary">
            Đăng Nhập
        </button>
    </form>

    <!-- Divider -->
    <div class="divider">
        <span>Hoặc đăng nhập bằng</span>
    </div>

    <!-- Social Login -->
    <div class="social-login">
        <button type="button" class="btn-secondary" onclick="loginWithGoogle()">
            <i class="fab fa-google" style="margin-right: 8px;"></i>
            Google
        </button>
        <button type="button" class="btn-secondary" onclick="loginWithFacebook()">
            <i class="fab fa-facebook-f" style="margin-right: 8px;"></i>
            Facebook
        </button>
    </div>

    <!-- Register Link -->
    <div class="register-link">
        Bạn chưa có tài khoản? <a href="#">Đăng Ký Ngay</a>
    </div>
</div>

<script>
    // Haptic feedback simulation
    function hapticFeedback() {
        if ('vibrate' in navigator) {
            navigator.vibrate(10);
        }
    }

    // Toggle password visibility
    function togglePassword() {
        hapticFeedback();
        const passwordInput = document.getElementById('password');
        const passwordIcon = document.getElementById('password-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordIcon.classList.remove('fa-eye');
            passwordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordIcon.classList.remove('fa-eye-slash');
            passwordIcon.classList.add('fa-eye');
        }
    }

    // Navigation functions
    function goBack() {
        hapticFeedback();
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/';
        }
    }

    // Language dropdown functions
    function toggleLanguageDropdown() {
        hapticFeedback();
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

    function selectLanguage(langCode, langDisplay) {
        hapticFeedback();
        
        // Update current language display
        document.getElementById('current-language').textContent = langDisplay;
        
        // Update active state
        document.querySelectorAll('.language-option').forEach(option => {
            option.classList.remove('active');
        });
        event.target.closest('.language-option').classList.add('active');
        
        // Close dropdown
        document.getElementById('language-options').classList.remove('show');
        document.querySelector('.language-dropdown').classList.remove('open');
        
        // Store language preference
        localStorage.setItem('selectedLanguage', langCode);
        
        // Show feedback
        showNativeAlert(`Đã chuyển sang ${langDisplay}`);
        
        // Here you would typically reload the page with new language
        // window.location.reload();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const languageSelector = document.querySelector('.language-selector');
        if (!languageSelector.contains(event.target)) {
            document.getElementById('language-options').classList.remove('show');
            document.querySelector('.language-dropdown').classList.remove('open');
        }
    });

    // Google Login
    function loginWithGoogle() {
        hapticFeedback();
        // Implement Google OAuth here
        alert('Tính năng đăng nhập Google sẽ được triển khai');
    }

    // Facebook Login
    function loginWithFacebook() {
        hapticFeedback();
        // Implement Facebook OAuth here
        alert('Tính năng đăng nhập Facebook sẽ được triển khai');
    }

    // Form validation with native-like feedback
    document.querySelector('form').addEventListener('submit', function(e) {
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        
        if (!phone || !password) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('Vui lòng điền đầy đủ thông tin');
            return;
        }
        
        // Basic phone validation for Vietnamese numbers
        const phoneRegex = /^(\+84|84|0)[1-9][0-9]{8,9}$/;
        if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('Số điện thoại không hợp lệ');
            return;
        }
    });

    // Native-like alert function
    function showNativeAlert(message) {
        // Create native-like alert
        const alertDiv = document.createElement('div');
        alertDiv.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            font-size: 16px;
            z-index: 10000;
            max-width: 300px;
            text-align: center;
            backdrop-filter: blur(10px);
        `;
        alertDiv.textContent = message;
        document.body.appendChild(alertDiv);
        
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Auto-format phone number
    document.getElementById('phone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.startsWith('84')) {
            value = '0' + value.substring(2);
        }
        if (value.startsWith('+84')) {
            value = '0' + value.substring(3);
        }
        e.target.value = value;
    });

    // Load saved language preference on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedLanguage = localStorage.getItem('selectedLanguage');
        if (savedLanguage) {
            const languageMap = {
                'vi': 'VI',
                'en': 'EN', 
                'zh': '中文',
                'ja': '日本語'
            };
            
            if (languageMap[savedLanguage]) {
                document.getElementById('current-language').textContent = languageMap[savedLanguage];
                
                // Update active state
                document.querySelectorAll('.language-option').forEach(option => {
                    option.classList.remove('active');
                    if (option.onclick.toString().includes(savedLanguage)) {
                        option.classList.add('active');
                    }
                });
            }
        }
    });
</script>
@endsection
