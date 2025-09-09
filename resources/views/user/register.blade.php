@extends('user.layouts.app')

@section('title', __('auth.register') . ' - ' . __('auth.tiktok_shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ __('auth.register') }}</div>
    <x-user.language-switcher />
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

    <!-- Register Form -->
    <form method="POST" action="{{ route('register.store') }}" id="registerForm">
        @csrf
        
        @if($errors->has('register'))
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                {{ $errors->first('register') }}
            </div>
        @endif
        
        <!-- Full Name Field -->
        <div class="form-group floating-label">
            <input 
                type="text" 
                id="full_name" 
                name="full_name" 
                class="form-input" 
                placeholder=" "
                value="{{ old('full_name') }}"
                required
            >
            <label class="form-label" for="full_name">{{ __('auth.full_name') }}</label>
            @error('full_name')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

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
                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                    <i class="fas fa-eye" id="password-icon"></i>
                </button>
            </div>
            @error('password')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password Field -->
        <div class="form-group floating-label">
            <div class="password-field">
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input" 
                    placeholder=" "
                    required
                >
                <label class="form-label" for="password_confirmation">{{ __('auth.confirm_password') }}</label>
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Referral Code Field -->
        <div class="form-group floating-label">
            <input 
                type="text" 
                id="referral_code" 
                name="referral_code" 
                class="form-input" 
                placeholder=" "
                value="{{ old('referral_code') }}"
            >
            <label class="form-label" for="referral_code">{{ __('auth.referral_code') }}</label>
            @error('referral_code')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Terms and Conditions -->
        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="agree_terms" name="agree_terms" class="checkbox" required>
                <label for="agree_terms" class="checkbox-label">{{ __('auth.agree_terms') }}</label>
            </div>
            @error('agree_terms')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Register Button -->
        <button type="submit" class="btn-primary">
            {{ __('auth.register_button') }}
        </button>
    </form>


    <!-- Login Link -->
    <div class="register-link">
        {{ __('auth.already_have_account') }} <a href="{{ route('login') }}">{{ __('auth.login_now') }}</a>
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
    function togglePassword(fieldId) {
        hapticFeedback();
        const passwordInput = document.getElementById(fieldId);
        const passwordIcon = document.getElementById(fieldId + '-icon');
        
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


    // Form validation with native-like feedback
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const fullName = document.getElementById('full_name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const agreeTerms = document.getElementById('agree_terms').checked;
        
        // Check required fields
        if (!fullName || !phone || !password || !passwordConfirmation) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('{{ __("auth.fill_all_fields") }}');
            return;
        }
        
        // Check terms agreement
        if (!agreeTerms) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('{{ __("auth.terms_required") }}');
            return;
        }
        
        // Check password match
        if (password !== passwordConfirmation) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('{{ __("auth.password_mismatch") }}');
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
        
        // Password strength validation
        if (password.length < 6) {
            e.preventDefault();
            hapticFeedback();
            showNativeAlert('{{ __("auth.password") }} must be at least 6 characters');
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

    // Real-time password confirmation validation
    document.getElementById('password_confirmation').addEventListener('input', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = e.target.value;
        
        if (passwordConfirmation && password !== passwordConfirmation) {
            e.target.style.borderColor = '#ff3b30';
        } else {
            e.target.style.borderColor = '#d1d1d6';
        }
    });

    // Real-time password validation
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (passwordConfirmation && password !== passwordConfirmation) {
            document.getElementById('password_confirmation').style.borderColor = '#ff3b30';
        } else {
            document.getElementById('password_confirmation').style.borderColor = '#d1d1d6';
        }
    });

</script>
@endsection
