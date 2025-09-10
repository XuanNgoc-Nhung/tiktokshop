<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', __('admin::cms.dashboard')) - {{ config('app.name', 'TikTok Shop Admin') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Styles -->
    <style>
        *{
            font-family: 'system-ui', sans-serif;
        }
        :root {
            --primary-color: #4A5568;
            --primary-dark: #2D3748;
            --primary-light: #718096;
            --secondary-color: #1A202C;
            --accent-color: #805AD5;
            --success-color: #38A169;
            --warning-color: #D69E2E;
            --danger-color: #E53E3E;
            --info-color: #3182CE;
            --light-color: #2D3748;
            --dark-color: #1A202C;
            --white: #FFFFFF;
            --gray-100: #1A202C;
            --gray-200: #2D3748;
            --gray-300: #4A5568;
            --gray-400: #718096;
            --gray-500: #A0AEC0;
            --gray-600: #CBD5E0;
            --gray-700: #E2E8F0;
            --gray-800: #F7FAFC;
            --gray-900: #FFFFFF;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.4);
            --border-radius: 0.375rem;
            --border-radius-lg: 0.5rem;
            --transition: all 0.15s ease-in-out;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: var(--gray-100);
            color: var(--gray-800);
            line-height: 1.6;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        .text-white {
            color: var(--white);
        }

        /* Form Labels */
        .form-label, label {
            color: #000000;
            font-weight: 500;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white);
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
        }

        /* Mobile-only close button inside sidebar header */
        #sidebarClose {
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.1rem;
            padding: 0.35rem 0.5rem;
            border-radius: var(--border-radius);
            cursor: pointer;
        }
        #sidebarClose:hover { background: rgba(255,255,255,0.12); }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 0.85rem 0.5rem;
        }

        .sidebar.collapsed .sidebar-header .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
            visibility: hidden;
            display: none;
        }

        .sidebar-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .sidebar-header p {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar.collapsed .sidebar-menu {
            padding: 0.5rem 0;
        }
        .sidebar.collapsed .menu-item {
            margin: 0.5rem 0;
        }

        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
        }

        .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--white);
        }

        .menu-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-right: 3px solid var(--white);
        }

        .menu-link i {
            width: 20px;
            margin-right: 0.75rem;
            text-align: center;
        }

        .menu-text {
            transition: var(--transition);
        }

        .sidebar.collapsed .menu-text {
            opacity: 0;
            width: 0;
            overflow: hidden;
            visibility: hidden;
            display: none;
        }

        .sidebar.collapsed .menu-link {
            justify-content: center;
            padding: 0.5rem 0.2rem;
            margin: 0.25rem 0.4rem;
            border-radius: var(--border-radius);
            min-height: 45px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .sidebar.collapsed .menu-link i {
            margin-right: 0;
            font-size: 0.95rem;
            width: 16px;
        }

        .sidebar.collapsed .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: scale(1.05);
        }

        .sidebar.collapsed .menu-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background: var(--dark-color);
            color: var(--white);
            padding: 0.5rem 0.75rem;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 1000;
            margin-left: 0.5rem;
            box-shadow: var(--shadow-lg);
        }

        .sidebar.collapsed .menu-link::before {
            content: '';
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: var(--dark-color);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 1000;
            margin-left: -0.25rem;
        }

        .sidebar.collapsed .menu-link:hover::after,
        .sidebar.collapsed .menu-link:hover::before {
            opacity: 1;
            visibility: visible;
        }


        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            transition: var(--transition);
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Top Navigation */
        .top-nav {
            background: var(--gray-200);
            padding: 0.5rem 2rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
            min-height: 60px;
            height: 60px;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--gray-600);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            width: 40px;
        }

        .sidebar-toggle:hover {
            background-color: var(--gray-300);
            color: var(--primary-color);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .language-selector {
            position: relative;
        }

        .language-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: var(--transition);
            height: 40px;
        }

        .language-btn:hover {
            background: var(--primary-dark);
        }

        .user-menu {
            position: relative;
        }

        .user-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            height: 40px;
        }

        .user-btn:hover {
            background-color: var(--gray-300);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Content Area */
        .content {
            padding: 2rem;
        }

        /* Cards */
        .card {
            background: var(--gray-200);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-300);
            background: var(--gray-300);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--gray-200);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-color);
        }

        .stat-card.success::before {
            background: var(--success-color);
        }

        .stat-card.warning::before {
            background: var(--warning-color);
        }

        .stat-card.danger::before {
            background: var(--danger-color);
        }

        .stat-card.info::before {
            background: var(--info-color);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.875rem;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--white);
        }

        .stat-icon.primary {
            background: var(--primary-color);
        }

        .stat-icon.success {
            background: var(--success-color);
        }

        .stat-icon.warning {
            background: var(--warning-color);
        }

        .stat-icon.danger {
            background: var(--danger-color);
        }

        .stat-icon.info {
            background: var(--info-color);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .stat-change.positive {
            color: var(--success-color);
        }

        .stat-change.negative {
            color: var(--danger-color);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            line-height: 1.5;
            border-radius: var(--border-radius);
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition);
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--gray-600);
            color: var(--gray-800);
            border-color: var(--gray-600);
        }

        .btn-secondary:hover {
            background: var(--gray-700);
            border-color: var(--gray-700);
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 0.25rem;
        }

        .btn-danger {
            background: var(--danger-color);
            color: var(--white);
            border-color: var(--danger-color);
        }

        .btn-danger:hover {
            background: #c53030;
            border-color: #c53030;
        }

        .btn-warning {
            background: var(--warning-color);
            color: var(--white);
            border-color: var(--warning-color);
        }

        .btn-warning:hover {
            background: #b7791f;
            border-color: #b7791f;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            background: var(--gray-200);
        }

        .table th,
        .table td {
            padding: 0.75rem;
            border: 1px solid var(--gray-400);
        }

        .table th {
            background: var(--primary-color);
            font-weight: 600;
            color: var(--white);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            font-weight: 400;
            background: var(--gray-200);
            color: var(--gray-800);
        }

        .table tbody tr:hover {
            background-color: var(--gray-300);
        }

        .table tbody tr:nth-child(even) {
            background-color: var(--gray-300);
        }

        .table tbody tr:nth-child(even):hover {
            background-color: var(--gray-400);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            /* Show the close button only on mobile */
            #sidebarClose { display: inline-flex !important; align-items: center; justify-content: center; }
            .sidebar-header { display: flex; align-items: center; justify-content: space-between; }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .content {
                padding: 1rem;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .top-nav {
                padding: 0.5rem 1rem;
                min-height: 50px;
                height: 50px;
            }

            /* Backdrop overlay when sidebar is open */
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 900;
                opacity: 0;
                visibility: hidden;
                transition: var(--transition);
            }
            .sidebar.show ~ .sidebar-overlay {
                opacity: 1;
                visibility: visible;
            }

            /* Ensure cards and inner blocks span full width */
            .card,
            .card-body,
            .card-header,
            .admin-container {
                width: 100%;
            }

            /* Horizontal scroll for wide tables on small screens */
            .table {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table thead,
            .table tbody {
                width: 100%;
            }

            .table th,
            .table td {
                white-space: nowrap;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--gray-300);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Dropdown */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--dark-color);
            border: 1px solid var(--gray-400);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            min-width: 200px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: var(--transition);
            margin-top: 0.5rem;
            display: none;
        }

        .dropdown.show .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            display: block;
        }

        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--white);
            text-decoration: none;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: var(--gray-300);
            color: var(--white);
        }

        .dropdown-divider {
            height: 1px;
            background-color: var(--gray-400);
            margin: 0.5rem 0;
        }

        /* Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toast {
            min-width: 260px;
            max-width: 360px;
            background: var(--dark-color);
            color: var(--white);
            border: 1px solid var(--gray-400);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            opacity: 0;
            transform: translateY(-10px);
            transition: var(--transition);
        }
        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        input[readonly] {
            background-color: #000000;
            cursor: default;
        }
        .toast-success { border-left: 4px solid var(--success-color); }
        .toast-error { border-left: 4px solid var(--danger-color); }
        .toast-info { border-left: 4px solid var(--info-color); }
        .toast-warning { border-left: 4px solid var(--warning-color); }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-crown"></i> <span class="menu-text">TikTok Shop</span></h2>
                {{-- <p class="menu-text">{{ __('admin::cms.admin_panel') }}</p> --}}
                <button id="sidebarClose" aria-label="Close sidebar" style="display:none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="sidebar-menu">
                <div class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="{{ __('admin::cms.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="menu-text">{{ __('admin::cms.dashboard') }}</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="{{ route('admin.user-management') }}" class="menu-link {{ request()->routeIs('admin.user-management') ? 'active' : '' }}" data-tooltip="{{ __('admin::cms.user_management') }}">
                        <i class="fas fa-users"></i>
                        <span class="menu-text">{{ __('admin::cms.user_management') }}</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link" data-tooltip="{{ __('admin::cms.order_management') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="menu-text">{{ __('admin::cms.order_management') }}</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link" data-tooltip="{{ __('admin::cms.product_management') }}">
                        <i class="fas fa-box"></i>
                        <span class="menu-text">{{ __('admin::cms.product_management') }}</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link" data-tooltip="{{ __('admin::cms.analytics') }}">
                        <i class="fas fa-chart-bar"></i>
                        <span class="menu-text">{{ __('admin::cms.analytics') }}</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link" data-tooltip="{{ __('admin::cms.system_settings') }}">
                        <i class="fas fa-cog"></i>
                        <span class="menu-text">{{ __('admin::cms.system_settings') }}</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Mobile overlay for sidebar -->
        <div class="sidebar-overlay" id="sidebarOverlay" aria-hidden="true"></div>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="nav-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb">
                        <i class="fas fa-home"></i>
                        <span>@yield('breadcrumb', __('admin::cms.dashboard'))</span>
                    </div>
                </div>
                
                <div class="nav-right">
                    <!-- Language Selector -->
                    <div class="language-selector dropdown">
                        <button class="language-btn" id="languageBtn">
                            <i class="fas fa-globe"></i>
                            <span id="currentLanguage">{{ ['vi'=>'VI','en'=>'EN','zh'=>'ZH','ja'=>'JA','bn'=>'BN'][app()->getLocale()] ?? strtoupper(app()->getLocale()) }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="languageMenu">
                            <a href="#" class="dropdown-item" data-lang="vi">
                                <i class="fas fa-flag"></i> {{ __('admin::cms.vietnamese') }}
                            </a>
                            <a href="#" class="dropdown-item" data-lang="en">
                                <i class="fas fa-flag"></i> {{ __('admin::cms.english') }}
                            </a>
                            <a href="#" class="dropdown-item" data-lang="zh">
                                <i class="fas fa-flag"></i> {{ __('admin::cms.chinese') }}
                            </a>
                            <a href="#" class="dropdown-item" data-lang="ja">
                                <i class="fas fa-flag"></i> {{ __('admin::cms.japanese') }}
                            </a>
                            <a href="#" class="dropdown-item" data-lang="bn">
                                <i class="fas fa-flag"></i> {{ __('admin::cms.bengali') }}
                            </a>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="user-menu dropdown">
                        <button class="user-btn" id="userBtn">
                            <div class="user-avatar">
                                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                            </div>
                            <span class="text-white">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userMenu">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user"></i> {{ __('admin::cms.profile') }}
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i> {{ __('admin::cms.settings') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('admin.logout') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i> {{ __('admin::cms.logout') }}
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>
        </main>
    </div>

    <div class="toast-container" id="toastContainer" aria-live="polite" aria-atomic="true"></div>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle with localStorage
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const isMobile = () => window.matchMedia('(max-width: 768px)').matches;

            // Áp dụng trạng thái đã lưu (chỉ desktop)
            if (!isMobile()) {
                const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                }
            } else {
                // Đảm bảo trạng thái đúng cho mobile
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }

            // Xử lý click toggle cho cả desktop và mobile
            sidebarToggle.addEventListener('click', function() {
                if (isMobile()) {
                    sidebar.classList.toggle('show');
                    return;
                }

                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem('sidebarCollapsed', isCurrentlyCollapsed.toString());
            });

            // Close from inside button (mobile)
            sidebarClose.addEventListener('click', function() {
                if (isMobile()) {
                    sidebar.classList.remove('show');
                }
            });

            // Close when tapping overlay (mobile)
            sidebarOverlay.addEventListener('click', function() {
                if (isMobile()) {
                    sidebar.classList.remove('show');
                }
            });
        });

        // Dropdown Toggle
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            const btn = dropdown.querySelector('button');
            const menu = dropdown.querySelector('.dropdown-menu');
            
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('show');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            // Check if click is outside any dropdown
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
            }
        });

        // Language Switcher
        document.querySelectorAll('[data-lang]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const lang = this.getAttribute('data-lang');
                
                console.log('Language change requested:', lang);
                
                // Show loading
                const currentLang = document.getElementById('currentLanguage');
                currentLang.innerHTML = '<div class="loading"></div>';
                
                // Change language
                fetch('{{ route("admin.set-language") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ language: lang })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        // Update the current language display
                        const langMap = {
                            'vi': 'VI',
                            'en': 'EN', 
                            'zh': 'ZH',
                            'ja': 'JA',
                            'bn': 'BN'
                        };
                        currentLang.textContent = langMap[lang] || (lang ? lang.toUpperCase() : 'EN');
                        
                        console.log('Language changed successfully, reloading page...');
                        
                        // Reload the page to apply language changes
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    } else {
                        console.error('Language change failed:', data.message);
                        currentLang.textContent = '{{ ['vi'=>'VI','en'=>'EN','zh'=>'ZH','ja'=>'JA','bn'=>'BN'][app()->getLocale()] ?? strtoupper(app()->getLocale()) }}';
                        alert('Failed to change language: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    currentLang.textContent = '{{ ['vi'=>'VI','en'=>'EN','zh'=>'ZH','ja'=>'JA','bn'=>'BN'][app()->getLocale()] ?? strtoupper(app()->getLocale()) }}';
                    alert('Error changing language: ' + error.message);
                });
            });
        });

        // Mobile sidebar toggle handled in the unified click handler above
        
        // Handle window resize to maintain sidebar state
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

            if (window.matchMedia('(max-width: 768px)').matches) {
                // Mobile view - remove desktop collapsed state
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            } else {
                // Desktop view - apply saved state and hide mobile overlay
                sidebar.classList.remove('show');
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('expanded');
                } else {
                    sidebar.classList.remove('collapsed');
                    mainContent.classList.remove('expanded');
                }
            }
        });

        // Toast helper
        (function() {
            const container = document.getElementById('toastContainer');
            function createToast(message, type) {
                const toast = document.createElement('div');
                toast.className = 'toast toast-' + (type || 'info');
                toast.innerHTML = '<div style="line-height:1.3;">' + message + '</div>';
                container.appendChild(toast);
                // Force reflow to enable transition
                void toast.offsetWidth;
                toast.classList.add('show');
                const timeout = setTimeout(() => removeToast(), 3500);
                function removeToast() {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        if (toast.parentNode) toast.parentNode.removeChild(toast);
                    }, 200);
                    clearTimeout(timeout);
                }
                toast.addEventListener('click', removeToast);
                return removeToast;
            }
            window.showToast = function(message, options) {
                const type = (options && options.type) || 'info';
                return createToast(String(message), type);
            };
        })();
    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
