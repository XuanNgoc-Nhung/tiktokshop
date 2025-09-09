@extends('user.layouts.app')

@section('title', __('auth.login') . ' - ' . __('auth.tiktok_shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ __('auth.login') }}</div>
    <x-language-selector />
</div>

<div class="container">
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            {{ __('auth.tiktok_shop') }}
        </div>
        <div class="logo-subtitle">{{ __('auth.smart_shopping') }}</div>
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
            <label class="form-label" for="phone">{{ __('auth.phone_number') }}</label>
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
                <label class="form-label" for="password">{{ __('auth.password') }}</label>
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
                <label for="remember" class="checkbox-label">{{ __('auth.remember_me') }}</label>
            </div>
            <a href="#" class="forgot-password">{{ __('auth.forgot_password') }}</a>
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn-primary">
            {{ __('auth.login_button') }}
        </button>
    </form>

    <!-- Divider -->
    <div class="divider">
        <span>{{ __('auth.or_login_with') }}</span>
    </div>

    <!-- Social Login -->
    <div class="social-login">
        <button type="button" class="btn-secondary" onclick="loginWithGoogle()">
            <i class="fab fa-google" style="margin-right: 8px;"></i>
            {{ __('auth.google') }}
        </button>
        <button type="button" class="btn-secondary" onclick="loginWithFacebook()">
            <i class="fab fa-facebook-f" style="margin-right: 8px;"></i>
            {{ __('auth.facebook') }}
        </button>
    </div>

    <!-- Register Link -->
    <div class="register-link">
        {{ __('auth.no_account') }} <a href="{{ route('register') }}">{{ __('auth.register_now') }}</a>
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


    // Google Login
    function loginWithGoogle() {
        hapticFeedback();
        // Implement Google OAuth here
        alert('{{ __("auth.google") }} login feature will be implemented');
    }

    // Facebook Login
    function loginWithFacebook() {
        hapticFeedback();
        // Implement Facebook OAuth here
        alert('{{ __("auth.facebook") }} login feature will be implemented');
    }

    // Form validation with native-like feedback
    document.querySelector('form').addEventListener('submit', function(e) {
        const phone = document.getElementById('phone').value;
        const password = document.getElementById('password').value;
        
        if (!phone || !password) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('{{ __("auth.fill_all_fields") }}');
            return;
        }
        
        // Basic phone validation for Vietnamese numbers
        const phoneRegex = /^(\+84|84|0)[1-9][0-9]{8,9}$/;
        if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('{{ __("auth.invalid_phone") }}');
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

</script>
@endsection
