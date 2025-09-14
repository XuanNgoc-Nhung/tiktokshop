<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TikTok Shop')</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios@1.6.8/dist/axios.min.js"></script>
    <script src="{{ asset('js/toast.js') }}"></script>
    <script>
        if (window.axios) {
            window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        }
    </script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 14px;
            background: #f8f9fa;
            min-height: 100vh;
            padding: 0;
            margin: 0;
            overflow-x: hidden;
            /* Đảm bảo body không ảnh hưởng đến fixed positioning */
            position: relative;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            /* Đảm bảo html không có overflow issues */
            overflow-x: hidden;
            height: 100%;
        }


        /* Main App Container */
        .app-container {
            max-width: 414px;
            margin: 0 auto;
            background: #ffffff;
            min-height: 100vh;
            position: relative;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            /* Đảm bảo container không ảnh hưởng đến fixed bottom-nav */
            overflow-x: hidden;
        }

        /* Safe Area for iPhone X+ */
        .safe-area-top {
            height: env(safe-area-inset-top, 0px);
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
        }

        .safe-area-bottom {
            height: env(safe-area-inset-bottom, 0px);
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
        }

        .container {
            width: 100%;
            /* background: #ffffff; */
            padding: 20px;
            position: relative;
        }

        /* Scrollable content area above fixed bottom nav */
        .content-area {
            flex: 1 1 auto;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            /* Reserve space so last elements aren't hidden behind bottom nav */
            padding-bottom: calc(72px + env(safe-area-inset-bottom, 0px));
        }

        /* Navigation Header */
        .nav-header {
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            padding: 5px 20px;
            border-bottom: 1px solid #e5e5e7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 414px;
            z-index: 1001;
            box-shadow: 0 2px 8px rgba(244, 208, 63, 0.2);
        }

        /* Reserve space for fixed header */
        .content-area {
            padding-top: calc(40px + env(safe-area-inset-top, 0px));
        }

        .nav-title {
            font-size: 17px;
            font-weight: 600;
            color: #000000;
            text-align: center;
            flex: 1;
        }

        .nav-button {
            background: none;
            border: none;
            color: #8b4513;
            font-size: 17px;
            font-weight: 600;
            padding: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .nav-button:hover {
            color: #654321;
            transform: scale(1.05);
        }

        .nav-button:disabled {
            color: #a0a0a0;
        }

        /* Toast Notification Styles */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }
        
        .toast {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 10px;
            padding: 16px;
            display: flex;
            align-items: center;
            animation: slideInRight 0.3s ease-out;
            border-left: 4px solid;
            min-width: 300px;
            backdrop-filter: blur(10px);
        }
        
        .toast.success {
            border-left-color: #28a745;
        }
        
        .toast.error {
            border-left-color: #dc3545;
        }
        
        .toast.warning {
            border-left-color: #ffc107;
        }
        
        .toast.info {
            border-left-color: #17a2b8;
        }
        
        .toast-icon {
            font-size: 20px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .toast.success .toast-icon {
            color: #28a745;
        }
        
        .toast.error .toast-icon {
            color: #dc3545;
        }
        
        .toast.warning .toast-icon {
            color: #ffc107;
        }
        
        .toast.info .toast-icon {
            color: #17a2b8;
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-title {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 4px;
            color: #333;
        }
        
        .toast-message {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }
        
        .toast-close {
            background: none;
            border: none;
            font-size: 18px;
            color: #999;
            cursor: pointer;
            padding: 0;
            margin-left: 12px;
            flex-shrink: 0;
        }
        
        .toast-close:hover {
            color: #666;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        
        .toast.hide {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        /* Language Selector */
        .language-selector {
            position: relative;
            display: inline-block;
        }

        .language-dropdown {
            background: none;
            border: none;
            color: #8b4513;
            font-size: 17px;
            font-weight: 600;
            padding: 8px 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .language-dropdown:hover {
            color: #654321;
            transform: scale(1.05);
        }

        .language-dropdown i {
            font-size: 12px;
            transition: transform 0.2s ease;
        }

        .language-dropdown.open i {
            transform: rotate(180deg);
        }

        .language-options {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e5e7;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-width: 120px;
            z-index: 1000;
            display: none;
            overflow: hidden;
        }

        .language-options.show {
            display: block;
        }

        .language-option {
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
            color: #333;
        }

        .language-option:hover {
            background-color: #f8f9fa;
        }

        .language-option.active {
            background-color: #f4d03f;
            color: #8b4513;
            font-weight: 600;
        }

        .flag-icon {
            width: 20px;
            height: 15px;
            border-radius: 2px;
            background-size: cover;
            background-position: center;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            color: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b4513;
            font-size: 20px;
            box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
        }

        .logo-subtitle {
            font-size: 16px;
            color: #ffffff;
            font-weight: 800;
        }

        .country-selector {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .country-selector:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
        }

        .flag {
            width: 20px;
            height: 20px;
            background: linear-gradient(45deg, #da251d, #ffcd00);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: white;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #000000;
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            -webkit-appearance: none;
            appearance: none;
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(0, 122, 255, 0.6);
            box-shadow: 0 0 0 3px rgba(0, 122, 255, 0.2);
            background: rgba(255, 255, 255, 0.2);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
        }

        /* Floating Label Effect */
        .floating-label {
            position: relative;
        }

        .floating-label .form-label {
            position: absolute;
            left: 16px;
            top: 12px;
            color: rgba(255, 170, 0, 0.8);
            font-size: 16px;
            transition: all 0.2s ease;
            pointer-events: none;
            /* background: rgba(0, 0, 0, 0.3); */
            padding: 0 4px;
            backdrop-filter: blur(5px);
            border-radius: 4px;
        }

        .floating-label .form-input:focus + .form-label,
        .floating-label .form-input:not(:placeholder-shown) + .form-label {
            top: -8px;
            font-size: 12px;
            color: #4fc3f7;
            background: rgba(0, 0, 0, 0.5);
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
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #4fc3f7;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #e1e8ed;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .checkbox:checked {
            background: #4ecdc4;
            border-color: #4ecdc4;
        }

        .checkbox-label {
            font-size: 14px;
            color: #000000;
            cursor: pointer;
        }

        .forgot-password {
            color: #4ecdc4;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password:hover {
            color: #45b7d1;
        }

        /* Button Styles */
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            color: #8b4513;
            border: none;
            border-radius: 10px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 20px;
            -webkit-tap-highlight-color: transparent;
            box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #f1c40f, #f4d03f);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(244, 208, 63, 0.4);
        }

        .btn-primary:active {
            transform: scale(0.98);
            background: linear-gradient(135deg, #e6b800, #f1c40f);
        }

        .btn-secondary {
            width: 100%;
            padding: 14px;
            background: #f2f2f7;
            color: #007aff;
            border: none;
            border-radius: 10px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-bottom: 14px;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-secondary:hover {
            background: #e5e5ea;
        }

        .btn-secondary:active {
            transform: scale(0.98);
            background: #d1d1d6;
        }

        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
            color: #7f8c8d;
            font-size: 14px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e8ed;
            z-index: 1;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .social-login {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .social-btn {
            flex: 1;
            padding: 15px;
            border: 2px solid #e1e8ed;
            border-radius: 12px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
        }

        .social-btn.google {
            color: #db4437;
        }

        .social-btn.facebook {
            color: #4267b2;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .register-link {
            text-align: center;
            color: #000000;
            font-size: 14px;
        }

        .register-link a {
            color: #4ecdc4;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #45b7d1;
        }

        .support-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4ecdc4, #45b7d1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(78, 205, 196, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .support-icon:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(78, 205, 196, 0.4);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 90px;
            right: 20px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b4513;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(244, 208, 63, 0.3);
            transition: all 0.3s ease;
            z-index: 1001;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            -webkit-tap-highlight-color: transparent;
            border: none;
            outline: none;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 25px rgba(244, 208, 63, 0.4);
        }

        .back-to-top:active {
            transform: scale(0.95);
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 414px;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            border-top: 1px solid #e5e5e7;
            display: flex;
            justify-content: space-around;
            padding: 12px 0 env(safe-area-inset-bottom, 12px) 0;
            z-index: 1000;
            box-shadow: 0 -2px 8px rgba(244, 208, 63, 0.2);
            /* Đảm bảo bottom-nav luôn cố định ở cuối màn hình */
            position: -webkit-sticky;
            position: sticky;
            position: fixed;
            /* Ngăn chặn việc trượt theo scroll */
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 12px;
            color: #8b4513;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-item:hover {
            color: #654321;
            transform: translateY(-2px);
        }

        .nav-item.active {
            color: #654321;
            transform: translateY(-2px);
        }

        .nav-item i {
            font-size: 22px;
            margin-bottom: 4px;
        }

        /* Common Account Styles */
        .account-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }

        .avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f4d03f, #f7dc6f);
            color: #8b4513;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(244, 208, 63, 0.3);
        }

        .avatar-img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            border-radius: 50%; 
            display: block; 
        }

        .vip-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #f59e0b;
        }

        .vip-badge i { 
            color: #ca8a04; 
        }

        /* Tier-specific styling */
        .vip-badge.tier-1 {
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            color: #374151;
            border: 1px solid #9ca3af;
        }
        .vip-badge.tier-1 i {
            color: #6b7280;
        }

        .vip-badge.tier-2 {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border: 1px solid #3b82f6;
        }
        .vip-badge.tier-2 i {
            color: #2563eb;
        }

        .vip-badge.tier-3 {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
            border: 1px solid #f59e0b;
        }
        .vip-badge.tier-3 i {
            color: #ca8a04;
        }

        .vip-badge.tier-4 {
            background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
            color: #7c3aed;
            border: 1px solid #a855f7;
        }
        .vip-badge.tier-4 i {
            color: #9333ea;
        }

        .vip-badge.tier-5 {
            background: linear-gradient(135deg, #fecaca, #fca5a5);
            color: #dc2626;
            border: 1px solid #ef4444;
        }
        .vip-badge.tier-5 i {
            color: #dc2626;
        }

        .menu-list .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #111827;
            text-decoration: none;
        }

        .menu-list .menu-item:last-child {
            border-bottom: none;
        }

        .menu-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #fef3c7;
            color: #8b4513;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }

        .menu-text {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .menu-title { 
            font-weight: 600; 
            font-size: 15px; 
        }

        .menu-desc { 
            font-size: 12px; 
            color: #6b7280; 
        }

        .logout-btn { 
            color: #dc2626; 
        }

        .helper { 
            font-size: 12px; 
            color: #6b7280; 
        }

        .form-label { 
            font-weight: 600; 
            color: #111827; 
        }

        .upload-tile { 
            border: 2px dashed #e5e7eb; 
            border-radius: 12px; 
            padding: 16px; 
            text-align: center; 
            cursor: pointer; 
            transition: all .2s ease; 
            position: relative; 
            background: #fafafa; 
        }

        .upload-tile:hover { 
            border-color: #d1d5db; 
            background: #f9fafb; 
        }

        .preview-wrapper { 
            position: relative; 
            border-radius: 10px; 
            overflow: hidden; 
            background: #f3f4f6; 
            height: 180px; 
        }

        /* Đảm bảo bottom-nav luôn cố định trên mọi thiết bị */
        @supports (position: fixed) {
            .bottom-nav {
                position: fixed !important;
                bottom: 0 !important;
            }
        }

        /* Responsive Design */
        @media (max-width: 414px) {
            .app-container {
                max-width: 100%;
            }
        }

        @media (max-width: 375px) {
            .container {
                padding: 16px;
            }
            
            .form-input {
                padding: 14px 16px;
                font-size: 16px;
            }
            
            .btn-primary {
                padding: 14px;
                font-size: 16px;
            }

            /* Adjust back to top button for smaller screens */
            .back-to-top {
                bottom: 80px;
                right: 15px;
                width: 45px;
                height: 45px;
                font-size: 16px;
            }

            .support-icon {
                bottom: 15px;
                right: 15px;
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }

        /* Đảm bảo bottom-nav không bị ảnh hưởng bởi transform hoặc animation */
        .bottom-nav {
            transform: translateX(-50%) translateZ(0);
            -webkit-transform: translateX(-50%) translateZ(0);
        }
        .app-container {
            font-family: 'Figtree', sans-serif;
            background-image: url('{{ asset($cauHinh->hinh_nen) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        
        .app-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .app-container > * {
            position: relative;
            z-index: 2;
        }
    </style>

</head>
<body>
    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>
    
    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="Lên đầu trang">
        <i class="fas fa-chevron-up"></i>
    </button>
    
    <div class="app-container">
        <!-- Safe Area Top -->
        <div class="safe-area-top"></div>
        
        <!-- Main Content -->
        <div class="content-area">
            @yield('content')
        </div>
        
        <!-- Safe Area Bottom -->
        <div class="safe-area-bottom"></div>
        
        <!-- Bottom Navigation -->
        <div class="bottom-nav">
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>{{ __('auth.home') }}</span>
            </a>
            <a href="{{ route('search') }}" class="nav-item {{ request()->is('search') ? 'active' : '' }}">
                <i class="fas fa-search"></i>
                <span>{{ __('auth.search') }}</span>
            </a>
            <a href="{{ route('endow') }}" class="nav-item {{ request()->is('endow') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-usd"></i>
                <span>{{ __('auth.endow') }}</span>
            </a>
            <a href="{{ route('account') }}" class="nav-item {{ request()->is('account') ? 'active' : '' }}">
                <i class="fas fa-user"></i>
                <span>{{ __('auth.account') }}</span>
            </a>
        </div>
    </div>

    <script>
        // Toast Notification Functions
        function showToast(type, title, message) {
            const toastContainer = document.getElementById('toastContainer');
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            // Get appropriate icon
            let icon = 'info-circle';
            switch(type) {
                case 'success':
                    icon = 'check-circle';
                    break;
                case 'error':
                    icon = 'exclamation-triangle';
                    break;
                case 'warning':
                    icon = 'exclamation-circle';
                    break;
                case 'info':
                    icon = 'info-circle';
                    break;
            }
            
            toast.innerHTML = `
                <i class="fas fa-${icon} toast-icon"></i>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button type="button" class="toast-close" onclick="closeToast(this)">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add to container
            toastContainer.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    closeToast(toast.querySelector('.toast-close'));
                }
            }, 5000);
        }
        
        // Function to close toast
        function closeToast(closeBtn) {
            const toast = closeBtn.closest('.toast');
            toast.classList.add('hide');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }

    // Haptic feedback simulation
    function hapticFeedback() {
        if ('vibrate' in navigator) {
            navigator.vibrate(10);
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

    // Back to Top functionality
    function initBackToTop() {
        const backToTopButton = document.getElementById('backToTop');
        
        // Show/hide button based on scroll position
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        }
        
        // Smooth scroll to top
        function scrollToTop() {
            hapticFeedback();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Event listeners
        window.addEventListener('scroll', toggleBackToTop);
        backToTopButton.addEventListener('click', scrollToTop);
        
        // Throttle scroll event for better performance
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            if (scrollTimeout) {
                clearTimeout(scrollTimeout);
            }
            scrollTimeout = setTimeout(toggleBackToTop, 10);
        });
    }

    // Initialize back to top when DOM is loaded
    document.addEventListener('DOMContentLoaded', initBackToTop);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

