@php
    use App\Helpers\LanguageHelper;
@endphp

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - TikTok Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-header h2 {
            color: #333;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .login-header p {
            color: #666;
            margin: 0;
            font-size: 0.9rem;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            height: auto;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.1rem rgba(102, 126, 234, 0.15);
        }
        .form-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #000000;
        }
        .btn-login {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 16px;
            font-weight: 500;
            font-size: 14px;
            width: 100%;
            color: #333;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background: #e9ecef;
            border-color: #ccc;
            color: #333;
        }
        .alert {
            border-radius: 4px;
            border: none;
            margin-bottom: 15px;
            font-size: 13px;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: 13px;
        }
        .back-link a:hover {
            color: #764ba2;
        }
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-right: none;
            border-radius: 4px 0 0 4px;
            font-size: 14px;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 4px 4px 0;
        }
        .input-group .btn {
            border-left: none;
            border-radius: 0 4px 4px 0;
            background: #f8f9fa;
            border-color: #ddd;
            color: #666;
            transition: all 0.2s ease;
        }
        .input-group .btn:hover {
            background: #e9ecef;
            border-color: #ccc;
            color: #333;
        }
        .input-group .btn:focus {
            box-shadow: 0 0 0 0.1rem rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .form-check-label {
            font-size: 13px;
        }
        
        /* Validation states */
        .form-control.is-valid {
            border-color: #28a745;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.94-.94 1.88-1.88'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4 1.4-1.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .form-control.is-valid:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.1rem rgba(40, 167, 69, 0.15);
        }
        
        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.1rem rgba(220, 53, 69, 0.15);
        }
        
        /* Bootstrap Toast Customization */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            min-width: 300px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .toast-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }
        
        .toast-body {
            padding: 12px 16px;
        }
        
        .toast-icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <div class="login-container">
        <div class="login-header">
            <div class="d-flex align-items-center justify-content-center mb-3">
                <i class="fas fa-leaf text-success me-2" style="font-size: 24px;"></i>
                <span class="text-success fw-bold" style="font-size: 20px;">TikTok Shop</span>
            </div>
            <p>{{ LanguageHelper::getAdminTranslation('admin_access') }}</p>
            
            <!-- Language Switcher -->
            <div class="d-flex justify-content-center mb-3">
                <x-admin.language-switcher />
            </div>
        </div>

        <!-- Language translations for JavaScript -->
        <script>
            window.adminTranslations = {
                'fill_all_fields': '{{ LanguageHelper::getAdminTranslation('fill_all_fields') }}',
                'invalid_credentials': '{{ LanguageHelper::getAdminTranslation('invalid_credentials') }}',
                'login_success': '{{ LanguageHelper::getAdminTranslation('login_success') }}',
                'error': '{{ LanguageHelper::getAdminTranslation('error') }}',
                'success': '{{ LanguageHelper::getAdminTranslation('success') }}',
                'logging_in': '{{ LanguageHelper::getAdminTranslation('logging_in') }}',
                'login_failed': '{{ LanguageHelper::getAdminTranslation('error') }}',
                'system_error': '{{ LanguageHelper::getAdminTranslation('error') }}',
                'connection_error': '{{ LanguageHelper::getAdminTranslation('error') }}'
            };
        </script>

        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('error', window.adminTranslations.error, '{{ session('error') }}');
                });
            </script>
        @endif

        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('success', window.adminTranslations.success, '{{ session('success') }}');
                });
            </script>
        @endif

        <form method="POST" action="{{ route('admin.login.authenticate') }}" class="needs-validation" novalidate>
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">{{ LanguageHelper::getAdminTranslation('email') }}</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       placeholder="{{ LanguageHelper::getAdminTranslation('email') }}"
                       required 
                       autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">{{ LanguageHelper::getAdminTranslation('password') }}</label>
                <div class="input-group">
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="{{ LanguageHelper::getAdminTranslation('password') }}"
                           required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    {{ LanguageHelper::getAdminTranslation('remember_me') }}
                </label>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-login">
                    {{ LanguageHelper::getAdminTranslation('login_button') }} »
                </button>
            </div>
        </form>
        <div class="back-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-2"></i>{{ LanguageHelper::getAdminTranslation('back_to_user_page') }}
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // Global functions for Bootstrap toast notifications
        function showToast(type, title, message) {
            console.log("showToast:");
            console.log(type);
            console.log(title);
            console.log(message);
            
            const toastContainer = document.getElementById('toastContainer');
            
            // Create unique ID for toast
            const toastId = 'toast-' + Date.now();
            
            // Get appropriate icon and color
            let icon = 'info-circle';
            let bgClass = 'bg-info';
            let textClass = 'text-info';
            
            switch(type) {
                case 'success':
                    icon = 'check-circle';
                    bgClass = 'bg-success';
                    textClass = 'text-success';
                    break;
                case 'error':
                    icon = 'exclamation-triangle';
                    bgClass = 'bg-danger';
                    textClass = 'text-danger';
                    break;
                case 'warning':
                    icon = 'exclamation-circle';
                    bgClass = 'bg-warning';
                    textClass = 'text-warning';
                    break;
                case 'info':
                    icon = 'info-circle';
                    bgClass = 'bg-info';
                    textClass = 'text-info';
                    break;
            }
            
            // Create Bootstrap toast element
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.id = toastId;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            
            toast.innerHTML = `
                <div class="toast-header ${bgClass} text-white">
                    <i class="fas fa-${icon} toast-icon"></i>
                    <strong class="me-auto">${title}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;
            
            // Add to container
            toastContainer.appendChild(toast);
            
            // Initialize and show Bootstrap toast
            const bsToast = new bootstrap.Toast(toast, {
                autohide: true,
                delay: 5000
            });
            
            bsToast.show();
            
            // Remove from DOM after hiding
            toast.addEventListener('hidden.bs.toast', function() {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            // Real-time validation
            const emailInput = document.getElementById('email');
            
            // Email validation on input
            emailInput.addEventListener('input', function() {
                const email = this.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !emailRegex.test(email)) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (email && emailRegex.test(email)) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-invalid', 'is-valid');
                }
            });
            
            // Password validation on input
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                
                if (password && (password.length < 6 || password.length > 30)) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (password && password.length >= 6 && password.length <= 30) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-invalid', 'is-valid');
                }
            });

            if (togglePassword) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'text') {
                        toggleIcon.classList.remove('fa-eye');
                        toggleIcon.classList.add('fa-eye-slash');
                    } else {
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    }
                });
            }

            // Form submission with Axios
            const form = document.querySelector('.needs-validation');
            const submitBtn = document.querySelector('.btn-login');
            const originalBtnText = submitBtn.innerHTML;

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Clear previous errors
                clearErrors();
                
                // Prepare form data
                const formData = new FormData(form);
                
                // Custom validation
                const email = formData.get('email');
                const password = formData.get('password');
                let isValid = true;
                let errorMessage = '';
                
                // Validate email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email || !emailRegex.test(email)) {
                    isValid = false;
                    errorMessage = window.adminTranslations.invalid_credentials;
                    showToast('error', window.adminTranslations.error, errorMessage);
                    document.getElementById('email').classList.add('is-invalid');
                    return;
                }
                
                // Validate password length
                if (!password || password.length < 6 || password.length > 30) {
                    isValid = false;
                    errorMessage = window.adminTranslations.invalid_credentials;
                    showToast('error', window.adminTranslations.error, errorMessage);
                    document.getElementById('password').classList.add('is-invalid');
                    return;
                }
                
                // Validate form
                if (!form.checkValidity()) {
                    form.classList.add('was-validated');
                    return;
                }

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + window.adminTranslations.logging_in;
                submitBtn.disabled = true;

                // Prepare data for submission
                const data = {
                    email: formData.get('email'),
                    password: formData.get('password'),
                    remember: formData.get('remember') ? true : false
                };

                // Send request with Axios
                axios.post('{{ route("admin.login.authenticate") }}', data, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(function(response) {
                    console.log("response:");
                    console.log(response);
                    
                    // Success - redirect to dashboard
                    if (response.data.success) {
                        showToast('success', window.adminTranslations.success, response.data.message || window.adminTranslations.login_success);
                        setTimeout(() => {
                            window.location.href = response.data.redirect || '{{ route("admin.dashboard") }}';
                        }, 1500);
                    }else{
                        console.log("lỗi response:");
                        console.log(response);
                        showToast('error', window.adminTranslations.login_failed, response.data.message || window.adminTranslations.system_error);
                    }
                })
                .catch(function(error) {
                    // Handle errors
                    if (error.response) {
                        console.log("lỗi error:");
                        console.log(error);
                        const errors = error.response.data.errors;
                        if (errors) {
                            // Display validation errors
                            displayErrors(errors);
                        } else if (error.response.data.message) {
                            showToast('error', window.adminTranslations.login_failed, error.response.data.message);
                        } else {
                            showToast('error', window.adminTranslations.system_error, window.adminTranslations.system_error);
                        }
                    } else {
                        showToast('error', window.adminTranslations.connection_error, window.adminTranslations.connection_error);
                    }
                })
                .finally(function() {
                    // Reset button state
                    submitBtn.innerHTML = originalBtnText;
                    submitBtn.disabled = false;
                });
            });

            // Function to display validation errors
            function displayErrors(errors) {
                Object.keys(errors).forEach(function(field) {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.classList.add('is-invalid');
                        const feedback = input.parentNode.querySelector('.invalid-feedback') || 
                                       input.parentNode.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.textContent = errors[field][0];
                            feedback.style.display = 'block';
                        }
                    }
                });
            }

            // Function to clear all errors
            function clearErrors() {
                const invalidInputs = document.querySelectorAll('.is-invalid');
                invalidInputs.forEach(input => input.classList.remove('is-invalid'));
                
                const validInputs = document.querySelectorAll('.is-valid');
                validInputs.forEach(input => input.classList.remove('is-valid'));
                
                const feedbacks = document.querySelectorAll('.invalid-feedback');
                feedbacks.forEach(feedback => {
                    feedback.style.display = 'none';
                    feedback.textContent = '';
                });
            }
            
            // Function to show alert messages (for backward compatibility)
            function showAlert(type, message) {
                const titles = {
                    'success': 'Thành công',
                    'danger': 'Lỗi',
                    'warning': 'Cảnh báo',
                    'info': 'Thông tin'
                };
                showToast(type, titles[type] || 'Thông báo', message);
            }
            
            // Test toast function (for debugging)
            window.testToast = function() {
                showToast('success', 'Test Thành công', 'Đây là thông báo test thành công!');
                setTimeout(() => showToast('error', 'Test Lỗi', 'Đây là thông báo test lỗi!'), 1000);
                setTimeout(() => showToast('warning', 'Test Cảnh báo', 'Đây là thông báo test cảnh báo!'), 2000);
                setTimeout(() => showToast('info', 'Test Thông tin', 'Đây là thông báo test thông tin!'), 3000);
            };
            
            // Hàm tự động điền dữ liệu đăng nhập admin
            window.fillAdminCredentials = function() {
                const emailInput = document.getElementById('email');
                const passwordInput = document.getElementById('password');
                
                if (emailInput && passwordInput) {
                    emailInput.value = 'admin@tiktokshop.com';
                    passwordInput.value = '123456789';
                    
                    // Trigger validation events
                    emailInput.dispatchEvent(new Event('input', { bubbles: true }));
                    passwordInput.dispatchEvent(new Event('input', { bubbles: true }));
                    
                    // Show success message
                    showToast('success', window.adminTranslations.success, 'Đã điền thông tin đăng nhập admin!');
                } else {
                    showToast('error', window.adminTranslations.error, 'Không thể tìm thấy các trường email hoặc password!');
                }
            };
        });
    </script>
</body>
</html>