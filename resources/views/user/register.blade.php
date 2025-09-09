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
    <form id="registerForm" novalidate autocomplete="off">
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
                autocomplete="off"
                autocapitalize="none"
                autocorrect="off"
                spellcheck="false"
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
                autocomplete="off"
                autocapitalize="none"
                autocorrect="off"
                spellcheck="false"
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
                    autocomplete="new-password"
                    autocapitalize="none"
                    autocorrect="off"
                    spellcheck="false"
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
                    autocomplete="new-password"
                    autocapitalize="none"
                    autocorrect="off"
                    spellcheck="false"
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
                autocomplete="off"
                autocapitalize="none"
                autocorrect="off"
                spellcheck="false"
            >
            <label class="form-label" for="referral_code">{{ __('auth.referral_code') }}</label>
            @error('referral_code')
                <div style="color: #ff3b30; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Terms and Conditions -->
        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="agree_terms" name="agree_terms" class="checkbox">
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


    // Form validation with toast feedback
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        // Suppress blur toasts triggered by submit click/blur
        window.__toastState.suppressBlurToasts = true;
        setTimeout(() => { window.__toastState.suppressBlurToasts = false; }, 1000);
        const fullNameInput = document.getElementById('full_name');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const agreeTermsInput = document.getElementById('agree_terms');

        const fullName = fullNameInput.value.trim();
        const phone = phoneInput.value.trim();
        const password = passwordInput.value;
        const passwordConfirmation = passwordConfirmationInput.value;
        const agreeTerms = agreeTermsInput.checked;

        console.log('[Register] Submit initiated', {
            fullNamePresent: !!fullName,
            phonePresent: !!phone,
            passwordLength: password.length,
            passwordConfirmationLength: passwordConfirmation.length,
            agreeTerms
        });
        
        // Reset visual error states
        [fullNameInput, phoneInput, passwordInput, passwordConfirmationInput].forEach(el => {
            el.style.borderColor = '#d1d1d6';
        });

        // Collect first missing field only (for concise toast)
        const firstMissing = [
            { el: fullNameInput, cond: !fullName, label: '{{ __("auth.full_name") }}' },
            { el: phoneInput, cond: !phone, label: '{{ __("auth.phone_number") }}' },
            { el: passwordInput, cond: !password, label: '{{ __("auth.password") }}' },
            { el: passwordConfirmationInput, cond: !passwordConfirmation, label: '{{ __("auth.confirm_password") }}' }
        ].find(item => item.cond);

        if (firstMissing) {
            e.preventDefault();
            hapticFeedback();
            showToast('error', '{{ __("auth.register") }}', '{{ __("auth.please_complete") }}: ' + firstMissing.label);
            console.warn('[Register] Missing field', firstMissing.label);
            firstMissing.el.style.borderColor = '#ff3b30';
            firstMissing.el.focus();
            return;
        }
        
        // Check terms agreement
        if (!agreeTerms) {
            e.preventDefault();
            hapticFeedback();
            showToast('error', '{{ __("auth.register") }}', '{{ __("auth.terms_required") }}');
            console.warn('[Register] Terms not agreed');
            agreeTermsInput.focus();
            return;
        }
        
        // Check password match
        if (password !== passwordConfirmation) {
            e.preventDefault();
            hapticFeedback();
            showToast('error', '{{ __("auth.register") }}', '{{ __("auth.password_mismatch") }}');
            console.warn('[Register] Password mismatch');
            passwordConfirmationInput.style.borderColor = '#ff3b30';
            passwordConfirmationInput.focus();
            return;
        }
        
        // Basic phone validation for Vietnamese numbers
        const phoneRegex = /^(\+84|84|0)[1-9][0-9]{8,9}$/;
        if (!phoneRegex.test(phone.replace(/\s/g, ''))) {
            e.preventDefault();
            hapticFeedback();
            showToast('error', '{{ __("auth.register") }}', '{{ __("auth.invalid_phone") }}');
            console.warn('[Register] Invalid phone format', { phone });
            phoneInput.style.borderColor = '#ff3b30';
            phoneInput.focus();
            return;
        }
        
        // Password strength validation
        if (password.length < 6) {
            e.preventDefault();
            hapticFeedback();
            showToast('error', '{{ __("auth.register") }}', '{{ __("auth.password") }} must be at least 6 characters');
            console.warn('[Register] Weak password length', { length: password.length });
            passwordInput.style.borderColor = '#ff3b30';
            passwordInput.focus();
            return;
        }

        console.log('[Register] Client-side validation passed, submitting to server');
        e.preventDefault();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const payload = {
                full_name: fullName,
                phone: phone,
                password: password,
                password_confirmation: passwordConfirmation,
                referral_code: document.getElementById('referral_code')?.value || '',
                agree_terms: agreeTerms ? 1 : 0,
            };
            console.log('[Register] Payload', { ...payload, password: '***', password_confirmation: '***' });

            const response = await window.axios.post(`{{ route('register.store') }}`, payload, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            console.log('[Register] Response', response.data);
            if (response.data.success) {
                showToast('success', '{{ __("auth.register") }}', '{{ __("auth.registration_success") }}');
                setTimeout(() => { window.location.href = `{{ route('login') }}`; }, 3000);
            } else {
                showToast('error', '{{ __("auth.register") }}', response.data.message);
            }

            console.log('[Register] Success', response.data);
            
        } catch (error) {
            console.error('[Register] Error', error);
            if (error.response) {
                const data = error.response.data || {};
                // Laravel validation errors format
                if (data.errors) {
                    const firstField = Object.keys(data.errors)[0];
                    const firstMsg = data.errors[firstField][0];
                    showToast('error', '{{ __("auth.error") }}', firstMsg || '{{ __("auth.error") }}');
                } else if (data.message) {
                    showToast('error', '{{ __("auth.error") }}', data.message);
                } else {
                    showToast('error', '{{ __("auth.error") }}', 'Request failed');
                }
            } else {
                showToast('error', '{{ __("auth.error") }}', 'Network error');
            }
        }
    });

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

    // Per-field blur validations with toast notifications
    (function() {
        const fullNameInput = document.getElementById('full_name');
        const phoneInput = document.getElementById('phone');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');

        const phoneRegex = /^(\+84|84|0)[1-9][0-9]{8,9}$/;

        fullNameInput.addEventListener('blur', function() {
            if (!fullNameInput.value.trim()) {
                console.warn('[Register][Blur] Full name missing');
                fullNameInput.style.borderColor = '#ff3b30';
            } else {
                console.log('[Register][Blur] Full name OK');
            }
        });

        phoneInput.addEventListener('blur', function() {
            const value = phoneInput.value.trim();
            if (!value) {
                console.warn('[Register][Blur] Phone missing');
                phoneInput.style.borderColor = '#ff3b30';
                return;
            }
            if (!phoneRegex.test(value.replace(/\s/g, ''))) {
                console.warn('[Register][Blur] Phone invalid', { phone: value });
                phoneInput.style.borderColor = '#ff3b30';
            } else {
                console.log('[Register][Blur] Phone OK');
            }
        });

        passwordInput.addEventListener('blur', function() {
            const value = passwordInput.value;
            if (!value) {
                console.warn('[Register][Blur] Password missing');
                passwordInput.style.borderColor = '#ff3b30';
                return;
            }
            if (value.length < 6) {
                console.warn('[Register][Blur] Password weak', { length: value.length });
                passwordInput.style.borderColor = '#ff3b30';
            } else {
                console.log('[Register][Blur] Password OK (length only)');
            }
        });

        passwordConfirmationInput.addEventListener('blur', function() {
            const value = passwordConfirmationInput.value;
            if (!value) {
                console.warn('[Register][Blur] Confirm password missing');
                passwordConfirmationInput.style.borderColor = '#ff3b30';
                return;
            }
            if (value !== passwordInput.value) {
                console.warn('[Register][Blur] Confirm password mismatch');
                passwordConfirmationInput.style.borderColor = '#ff3b30';
            } else {
                console.log('[Register][Blur] Confirm password OK');
            }
        });
    })();

</script>
@endsection
