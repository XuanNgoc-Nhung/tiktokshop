@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__home = [LanguageHelper::class, 'getHomeTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
@endphp

@extends('user.layouts.app')

@section('title', ($__account('account') ?? 'Tài khoản') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<!-- Navigation Header -->
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('account') ?? 'Tài khoản' }}</div>
    <x-user.language-switcher />
    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '{{ route('dashboard') }}';
            }
        }
    </script>
    <style>
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
        .menu-title { font-weight: 600; font-size: 15px; }
        .menu-desc { font-size: 12px; color: #6b7280; }
        .logout-btn { color: #dc2626; }
    </style>
</div>

<div class="container">
    <!-- User Info -->
    <div class="account-card p-3 mb-3">
        <div class="d-flex align-items-center">
            <div class="avatar me-3">
                {{ strtoupper(mb_substr($user->name ?? $user->phone ?? 'U', 0, 1)) }}
            </div>
            <div class="flex-grow-1">
                <div class="fw-bold" style="font-size:16px; color:#111827;">
                    {{ $user->name ?? 'User' }}
                </div>
                <div class="text-muted" style="font-size:13px;">
                    <i class="fas fa-phone me-1"></i> {{ $user->phone ?? '—' }}
                </div>
                @php
                    $balance = optional($user->profile)->so_du;
                @endphp
                <div class="mt-1" style="font-size:13px">
                    <i class="fas fa-money-bill me-1"></i>
                    <span>
                        {{ isset($balance) ? number_format((float)$balance, 0, '.', ',') : '0' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Personal Menus -->
    <div class="account-card menu-list mb-3">
        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-id-card"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('personal_info') }}</span>
                    <span class="menu-desc">{{ $__account('personal_info_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-building-columns"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('bank') }}</span>
                    <span class="menu-desc">{{ $__account('bank_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-shield-check"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('kyc') }}</span>
                    <span class="menu-desc">{{ $__account('kyc_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-clock-rotate-left"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('account_history') }}</span>
                    <span class="menu-desc">{{ $__account('account_history_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('orders') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-shopping-bag"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('order_history') }}</span>
                    <span class="menu-desc">{{ $__account('order_history_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-lock"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('password') }}</span>
                    <span class="menu-desc">{{ $__account('password_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-headset"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('support') }}</span>
                    <span class="menu-desc">{{ $__account('support_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="javascript:void(0)" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-circle-info"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('about_us') }}</span>
                    <span class="menu-desc">{{ $__account('about_us_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="#" class="menu-item logout-btn" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
            <div class="d-flex align-items-center">
                <div class="menu-icon" style="background:#fee2e2;color:#dc2626;"><i class="fas fa-sign-out-alt"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('logout') }}</span>
                    <span class="menu-desc">{{ $__account('logout_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</div>

@endsection


