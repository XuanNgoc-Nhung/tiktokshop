@php
    use App\Helpers\LanguageHelper;
    use Illuminate\Support\Facades\Auth;
    $__ = [LanguageHelper::class, 'getUserTranslation'];
    $__account = fn($key) => LanguageHelper::getTranslationFromFile('account', $key, 'user');
    $user = Auth::user();
    $profile = optional($user)->profile;
@endphp

@extends('user.layouts.app')

@section('title', ($__account('support') ?? 'Hỗ trợ') . ' - ' . ($__('tiktok_shop') ?? 'TikTok Shop'))

@section('content')
<div class="nav-header">
    <button class="nav-button" onclick="goBack()">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="nav-title">{{ $__account('support') ?? 'Hỗ trợ' }}</div>
    <x-user.language-switcher />
    <script>
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = '{{ route('account') }}';
            }
        }
    </script>
    <style>
        .form-control { border-radius: 10px; }
        .save-btn {
            background: #111827;
            color: #ffffff;
            border-radius: 12px;
            padding: 10px 16px;
            border: none;
        }
    </style>
</div>

<div class="container">
     <!-- User Info -->
     <x-user-info-card />
     
     <!-- Support Channels -->
     <div class="account-card p-3">
         <h5 class="mb-3">{{ $__account('support_channels') ?? 'Kênh hỗ trợ' }}</h5>
         
         <!-- Facebook Support -->
         <div class="support-item" onclick="openSupport('facebook')">
             <div class="support-icon facebook-icon">
                 <i class="fab fa-facebook-f"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('facebook_support') ?? 'Facebook' }}</h6>
                 <p class="support-desc">{{ $__account('facebook_desc') ?? 'Liên hệ qua Facebook Messenger' }}</p>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-chevron-right"></i>
             </div>
         </div>

         <!-- Zalo Support -->
         <div class="support-item" onclick="openSupport('zalo')">
             <div class="support-icon zalo-icon">
                 <i class="fas fa-comments"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('zalo_support') ?? 'Zalo' }}</h6>
                 <p class="support-desc">{{ $__account('zalo_desc') ?? 'Chat trực tiếp qua Zalo' }}</p>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-chevron-right"></i>
             </div>
         </div>

         <!-- Telegram Support -->
         <div class="support-item" onclick="openSupport('telegram')">
             <div class="support-icon telegram-icon">
                 <i class="fab fa-telegram-plane"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('telegram_support') ?? 'Telegram' }}</h6>
                 <p class="support-desc">{{ $__account('telegram_desc') ?? 'Tham gia nhóm Telegram' }}</p>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-chevron-right"></i>
             </div>
         </div>

         <!-- WhatsApp Support -->
         <div class="support-item" onclick="openSupport('whatsapp')">
             <div class="support-icon whatsapp-icon">
                 <i class="fab fa-whatsapp"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('whatsapp_support') ?? 'WhatsApp' }}</h6>
                 <p class="support-desc">{{ $__account('whatsapp_desc') ?? 'Liên hệ qua WhatsApp' }}</p>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-chevron-right"></i>
             </div>
         </div>

         <!-- Hotline Support -->
         <div class="support-item" onclick="openSupport('hotline')">
             <div class="support-icon hotline-icon">
                 <i class="fas fa-phone"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('hotline_support') ?? 'Hotline' }}</h6>
                 <p class="support-desc">{{ $__account('hotline_desc') ?? 'Gọi điện trực tiếp' }}</p>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-chevron-right"></i>
             </div>
         </div>

         <!-- Email Support -->
         <div class="support-item" onclick="openSupport('email')">
             <div class="support-icon email-icon">
                 <i class="fas fa-envelope"></i>
             </div>
             <div class="support-content">
                 <h6 class="support-title">{{ $__account('email_support') ?? 'Email' }}</h6>
                 <p class="support-desc">{{ $__account('email_desc') ?? 'Gửi email hỗ trợ' }}</p>
             </div>
             <div class="support-arrow">
                 <i class="fas fa-chevron-right"></i>
             </div>
         </div>
     </div>
</div>

<style>
/* Support Items Styles */
.support-item {
    display: flex;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: all 0.3s ease;
}

.support-item:last-child {
    border-bottom: none;
}

.support-item:hover {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 12px 8px;
    margin: 0 -8px;
}

.support-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-size: 16px;
    color: white;
}

.facebook-icon { background: linear-gradient(135deg, #1877f2, #42a5f5); }
.zalo-icon { background: linear-gradient(135deg, #0068ff, #00a8ff); }
.telegram-icon { background: linear-gradient(135deg, #0088cc, #00bcd4); }
.whatsapp-icon { background: linear-gradient(135deg, #25d366, #4caf50); }
.hotline-icon { background: linear-gradient(135deg, #ff5722, #ff9800); }
.email-icon { background: linear-gradient(135deg, #9c27b0, #e91e63); }

.support-content {
    flex: 1;
}

.support-title {
    font-size: 16px;
    font-weight: 600;
    color: #111827;
    margin: 0 0 2px 0;
}

.support-desc {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

.support-arrow {
    color: #9ca3af;
    font-size: 14px;
}
</style>

<script>
// Support channel data
const supportChannels = {
    facebook: {
        url: 'https://m.me/tiktokshop.support',
        name: 'Facebook Messenger'
    },
    zalo: {
        url: 'https://zalo.me/0123456789',
        name: 'Zalo Chat'
    },
    telegram: {
        url: 'https://t.me/tiktokshop_support',
        name: 'Telegram Group'
    },
    whatsapp: {
        url: 'https://wa.me/84123456789',
        name: 'WhatsApp'
    },
    hotline: {
        url: 'tel:1900123456',
        name: 'Hotline'
    },
    email: {
        url: 'mailto:support@tiktokshop.com',
        name: 'Email Support'
    }
};

function openSupport(channel) {
    const channelData = supportChannels[channel];
    if (channelData) {
        if (channel === 'email' || channel === 'hotline') {
            window.location.href = channelData.url;
        } else {
            window.open(channelData.url, '_blank');
        }
        
        // Show success message
        if (typeof window.showToast === 'function') {
            window.showToast('success', 'Mở kênh hỗ trợ', `Đang mở ${channelData.name}...`);
        }
    }
}
</script>

@endsection


