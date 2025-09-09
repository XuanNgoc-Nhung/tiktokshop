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
    <form method="POST" action="{{ route('register.store') }}" id="registerForm" novalidate autocomplete="off">
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
                autocomplete="off"
                autocapitalize="none"
                autocorrect="off"
                spellcheck="false"
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
                    autocomplete="new-password"
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
                    autocomplete="new-password"
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
    // Global toast control state
    window.__toastState = {
        lastKey: '',
        lastAt: 0,
        suppressBlurToasts: false
    };
    // Ensure toast function exists (fallback if layout script not yet loaded)
    if (typeof window.showToast !== 'function') {
        window.showToast = function(type, title, message) {
            console.log('[Toast:FALLBACK]', { type, title, message });
            // De-duplicate within 800ms
            const key = `${type}|${title}|${message}`;
            const now = Date.now();
            if (window.__toastState && window.__toastState.lastKey === key && (now - window.__toastState.lastAt) < 800) {
                return;
            }
            if (window.__toastState) { window.__toastState.lastKey = key; window.__toastState.lastAt = now; }
            // Clear bootstrap container if exists to ensure single toast
            const bs = document.getElementById('bsToastContainer');
            if (bs) while (bs.firstChild) bs.removeChild(bs.firstChild);
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                container.style.position = 'fixed';
                container.style.top = '20px';
                container.style.right = '20px';
                container.style.zIndex = '9999';
                document.body.appendChild(container);
            }
            // Ensure only one fallback toast
            while (container.firstChild) container.removeChild(container.firstChild);
            const toast = document.createElement('div');
            toast.className = 'toast ' + (type || 'error');
            toast.style.background = 'white';
            toast.style.borderRadius = '12px';
            toast.style.boxShadow = '0 4px 20px rgba(0,0,0,0.15)';
            toast.style.marginBottom = '10px';
            toast.style.padding = '16px';
            toast.style.display = 'flex';
            toast.style.alignItems = 'center';
            toast.style.borderLeft = '4px solid';
            toast.style.minWidth = '300px';
            if (type === 'success') toast.style.borderLeftColor = '#28a745';
            else if (type === 'warning') toast.style.borderLeftColor = '#ffc107';
            else if (type === 'info') toast.style.borderLeftColor = '#17a2b8';
            else toast.style.borderLeftColor = '#dc3545';
            toast.innerHTML = `
                <div style="margin-right:12px;font-weight:700;">${title || ''}</div>
                <div style="flex:1;color:#666;">${message || ''}</div>
            `;
            container.appendChild(toast);
            setTimeout(() => { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 4000);
        }
    }

    // Override to use Bootstrap Toast after all scripts loaded
    window.addEventListener('load', function() {
        try {
            if (!window.bootstrap || !window.bootstrap.Toast) return;

            window.showToast = function(type, title, message) {
                // De-duplicate within 800ms
                const key = `${type}|${title}|${message}`;
                const now = Date.now();
                if (window.__toastState && window.__toastState.lastKey === key && (now - window.__toastState.lastAt) < 800) {
                    return;
                }
                if (window.__toastState) { window.__toastState.lastKey = key; window.__toastState.lastAt = now; }
                const containerId = 'bsToastContainer';
                let container = document.getElementById(containerId);
                if (!container) {
                    container = document.createElement('div');
                    container.id = containerId;
                    container.style.position = 'fixed';
                    container.style.top = '16px';
                    container.style.left = '50%';
                    container.style.transform = 'translateX(-50%)';
                    container.style.zIndex = '1080';
                    container.style.pointerEvents = 'none';
                    container.setAttribute('aria-live', 'polite');
                    container.setAttribute('aria-atomic', 'true');
                    document.body.appendChild(container);
                }
                // Only one toast at a time
                while (container.firstChild) {
                    container.removeChild(container.firstChild);
                }
                // Also clear fallback container if present
                const fb = document.getElementById('toastContainer');
                if (fb) while (fb.firstChild) fb.removeChild(fb.firstChild);

                const typeClasses = {
                    success: { bg: 'bg-success', icon: '✅' },
                    error:   { bg: 'bg-danger',  icon: '⚠️' },
                    warning: { bg: 'bg-warning', icon: '⚠️' },
                    info:    { bg: 'bg-info',    icon: 'ℹ️' }
                };
                const cfg = typeClasses[type] || typeClasses.info;

                const toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center show text-white border-0 shadow rounded-3 ${cfg.bg}`;
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');
                toastEl.style.minWidth = '320px';
                toastEl.style.pointerEvents = 'auto';
                toastEl.style.padding = '8px 12px';
                toastEl.innerHTML = `
                    <div class="toast-body d-flex align-items-center gap-2 w-100 justify-content-between" style="font-weight:500;">
                        <div class="d-flex align-items-center gap-2" style="flex:1 1 auto; min-width:0;">
                            <span style="font-size:16px; flex:0 0 auto;">${cfg.icon}</span>
                            <div style="line-height:1.3; overflow:hidden; text-overflow:ellipsis;">
                                <div style="font-size:14px;">${title || ''}</div>
                                <div style="font-size:13px;opacity:.95;">${message || ''}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white" style="margin-left:auto;" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;

                container.appendChild(toastEl);
                const toast = new window.bootstrap.Toast(toastEl, { delay: 3000, autohide: true });
                toast.show();

                toastEl.addEventListener('hidden.bs.toast', function() {
                    if (toastEl && toastEl.parentNode) toastEl.parentNode.removeChild(toastEl);
                });
            }
        } catch (err) {
            console.error('[Toast Override] Failed to initialize Bootstrap toast', err);
        }
    });

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
