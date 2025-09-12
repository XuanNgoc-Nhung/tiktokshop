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
</div>

<div class="container">
    <!-- User Info -->
    <x-user-info-card />

    <!-- Personal Menus -->
    <div class="account-card menu-list mb-3">
        <a href="{{ route('account.achievement') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-trophy"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('achievement') }}</span>
                    <span class="menu-desc">{{ $__account('achievement_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('account.personal-info') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-id-card"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('personal_info') }}</span>
                    <span class="menu-desc">{{ $__account('personal_info_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('account.bank') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-building-columns"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('bank') }}</span>
                    <span class="menu-desc">{{ $__account('bank_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('account.kyc') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-shield-check"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('kyc') }}</span>
                    <span class="menu-desc">{{ $__account('kyc_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('account.account-history') }}" class="menu-item">
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

        <a href="{{ route('account.password') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-lock"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('password') }}</span>
                    <span class="menu-desc">{{ $__account('password_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('account.support') }}" class="menu-item">
            <div class="d-flex align-items-center">
                <div class="menu-icon"><i class="fas fa-headset"></i></div>
                <div class="menu-text">
                    <span class="menu-title">{{ $__account('support') }}</span>
                    <span class="menu-desc">{{ $__account('support_desc') }}</span>
                </div>
            </div>
            <i class="fas fa-chevron-right text-muted"></i>
        </a>

        <a href="{{ route('account.about-us') }}" class="menu-item">
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


